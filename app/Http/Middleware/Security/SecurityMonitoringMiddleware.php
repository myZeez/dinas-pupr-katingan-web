<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Monitoring Middleware
 * 
 * Lightweight monitoring untuk aktivitas security-critical.
 * Hanya log events penting, tidak semua request.
 * 
 * Digunakan pada: Admin routes, sensitive operations
 * Performance: Minimal logging, conditional based
 */
class SecurityMonitoringMiddleware
{
    /**
     * Paths yang perlu monitoring
     */
    private const MONITORED_PATHS = [
        'admin',
        'login',
        'password',
        'user',
        'account'
    ];

    /**
     * Suspicious user agents patterns
     */
    private const SUSPICIOUS_AGENTS = [
        'bot',
        'crawler',
        'spider',
        'scraper',
        'scanner',
        'curl',
        'wget',
        'python',
        'perl',
        'ruby'
    ];

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Pre-request monitoring
        $this->monitorRequest($request);

        $response = $next($request);

        // Post-request monitoring
        $this->monitorResponse($request, $response, $startTime);

        return $response;
    }

    /**
     * Monitor incoming request
     */
    private function monitorRequest(Request $request): void
    {
        // Hanya monitor paths yang penting
        if (!$this->shouldMonitor($request)) {
            return;
        }

        $suspiciousActivity = $this->detectSuspiciousActivity($request);

        if ($suspiciousActivity) {
            Log::warning('SECURITY: Suspicious activity detected', [
                'type' => $suspiciousActivity,
                'ip' => $request->ip(),
                'path' => $request->path(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);
        }
    }

    /**
     * Monitor response
     */
    private function monitorResponse(Request $request, Response $response, float $startTime): void
    {
        // Log unauthorized access attempts (4xx responses)
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
            $this->logUnauthorizedAccess($request, $response);
        }

        // Log slow requests (potential DoS)
        $duration = microtime(true) - $startTime;
        if ($duration > 5.0) { // 5 seconds
            Log::warning('SECURITY: Slow request detected', [
                'ip' => $request->ip(),
                'path' => $request->path(),
                'duration' => round($duration, 2),
                'status' => $response->getStatusCode(),
                'timestamp' => now()
            ]);
        }
    }

    /**
     * Check if request should be monitored
     */
    private function shouldMonitor(Request $request): bool
    {
        $path = strtolower($request->path());

        foreach (self::MONITORED_PATHS as $monitoredPath) {
            if (str_contains($path, $monitoredPath)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect suspicious activity patterns
     */
    private function detectSuspiciousActivity(Request $request): ?string
    {
        $userAgent = strtolower($request->userAgent() ?? '');

        // Check suspicious user agents
        foreach (self::SUSPICIOUS_AGENTS as $agent) {
            if (str_contains($userAgent, $agent)) {
                return 'suspicious_user_agent';
            }
        }

        // Check rapid successive requests (basic rate limiting detection)
        if ($this->isRapidRequest($request)) {
            return 'rapid_requests';
        }

        // Check unusual request patterns
        if ($this->hasUnusualPattern($request)) {
            return 'unusual_pattern';
        }

        return null;
    }

    /**
     * Detect rapid successive requests
     */
    private function isRapidRequest(Request $request): bool
    {
        // Implementasi sederhana dengan session
        $lastRequest = session('last_request_time', 0);
        $currentTime = time();

        session(['last_request_time' => $currentTime]);

        // Jika request dalam 1 detik terakhir
        return ($currentTime - $lastRequest) < 1;
    }

    /**
     * Check for unusual request patterns
     */
    private function hasUnusualPattern(Request $request): bool
    {
        // Request dengan banyak parameter
        if (count($request->all()) > 50) {
            return true;
        }

        // Request dengan URL sangat panjang
        if (strlen($request->fullUrl()) > 2000) {
            return true;
        }

        // Request tanpa User-Agent (unusual untuk browser)
        if (empty($request->userAgent()) && $request->path() !== 'up') {
            return true;
        }

        return false;
    }

    /**
     * Log unauthorized access attempts
     */
    private function logUnauthorizedAccess(Request $request, Response $response): void
    {
        // Hanya log untuk admin paths atau critical errors
        if (!str_contains($request->path(), 'admin') && $response->getStatusCode() !== 403) {
            return;
        }

        Log::warning('SECURITY: Unauthorized access attempt', [
            'ip' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'status' => $response->getStatusCode(),
            'user_agent' => $request->userAgent(),
            'user_id' => Auth::id(),
            'timestamp' => now()
        ]);
    }
}
