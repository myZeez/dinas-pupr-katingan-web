<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Brute Force Protection Middleware
 * 
 * Proteksi terhadap brute force attacks pada login dan form sensitif.
 * Menggunakan rate limiting dengan Redis/Cache.
 * 
 * Digunakan pada: Login routes, admin routes
 * Performance: Cache-based, minimal database impact
 */
class BruteForceProtectionMiddleware
{
    /**
     * Rate limiting configuration
     */
    private const MAX_ATTEMPTS = 5;
    private const BLOCK_DURATION = 300; // 5 minutes
    private const SUSPICIOUS_THRESHOLD = 10; // 10 attempts = critical alert

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $route = $request->route()->getName() ?? $request->path();

        // Check jika IP sudah diblokir
        if ($this->isBlocked($ip, $route)) {
            $this->logBlockedAttempt($request, $ip, $route);
            return $this->blockResponse();
        }

        // Process request
        $response = $next($request);

        // Jika login failed, increment attempt counter
        if ($this->isFailedLoginAttempt($request, $response)) {
            $this->recordFailedAttempt($ip, $route);
        }

        // Jika login successful, clear attempt counter
        if ($this->isSuccessfulLogin($request, $response)) {
            $this->clearFailedAttempts($ip, $route);
        }

        return $response;
    }

    /**
     * Check if IP is currently blocked
     */
    private function isBlocked(string $ip, string $route): bool
    {
        $key = "brute_force_block:{$ip}:{$route}";
        return Cache::has($key);
    }

    /**
     * Record failed login attempt
     */
    private function recordFailedAttempt(string $ip, string $route): void
    {
        $key = "brute_force_attempts:{$ip}:{$route}";
        $attempts = Cache::get($key, 0) + 1;

        // Store attempt count dengan TTL
        Cache::put($key, $attempts, now()->addMinutes(60));

        // Block IP jika melebihi threshold
        if ($attempts >= self::MAX_ATTEMPTS) {
            $this->blockIp($ip, $route, $attempts);
        }

        // Log suspicious activity
        if ($attempts >= self::SUSPICIOUS_THRESHOLD) {
            Log::critical('SECURITY: Suspicious brute force activity', [
                'ip' => $ip,
                'route' => $route,
                'attempts' => $attempts,
                'timestamp' => now()
            ]);
        }
    }

    /**
     * Block IP address
     */
    private function blockIp(string $ip, string $route, int $attempts): void
    {
        $blockKey = "brute_force_block:{$ip}:{$route}";
        Cache::put($blockKey, $attempts, now()->addSeconds(self::BLOCK_DURATION));

        Log::warning('SECURITY: IP blocked due to brute force', [
            'ip' => $ip,
            'route' => $route,
            'attempts' => $attempts,
            'block_duration' => self::BLOCK_DURATION,
            'timestamp' => now()
        ]);
    }

    /**
     * Clear failed attempts pada successful login
     */
    private function clearFailedAttempts(string $ip, string $route): void
    {
        $key = "brute_force_attempts:{$ip}:{$route}";
        Cache::forget($key);
    }

    /**
     * Detect failed login attempt
     */
    private function isFailedLoginAttempt(Request $request, Response $response): bool
    {
        // Check untuk login route
        if (!in_array($request->route()->getName(), ['login', 'password.request'])) {
            return false;
        }

        // POST request dengan redirect (biasanya failed login)
        if ($request->isMethod('POST') && $response->isRedirection()) {
            // Check jika ada session error (indikasi failed login)
            return session()->has('errors') || session()->has('error');
        }

        return false;
    }

    /**
     * Detect successful login
     */
    private function isSuccessfulLogin(Request $request, Response $response): bool
    {
        // POST login dengan redirect dan authenticated user
        return $request->isMethod('POST')
            && $response->isRedirection()
            && Auth::check()
            && $request->route()->getName() === 'login';
    }

    /**
     * Log blocked attempt
     */
    private function logBlockedAttempt(Request $request, string $ip, string $route): void
    {
        Log::warning('SECURITY: Brute force attempt blocked', [
            'ip' => $ip,
            'route' => $route,
            'path' => $request->path(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);
    }

    /**
     * Return blocked response
     */
    private function blockResponse(): Response
    {
        return response()->json([
            'error' => 'Too many attempts. Please try again later.',
            'retry_after' => self::BLOCK_DURATION
        ], 429);
    }
}
