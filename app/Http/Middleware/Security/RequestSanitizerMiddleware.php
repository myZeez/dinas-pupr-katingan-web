<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Request Sanitizer Middleware
 * 
 * Menggabungkan proteksi untuk:
 * - SQL Injection attacks
 * - Path Traversal attacks
 * - XSS (Cross-Site Scripting) attacks
 * - Command Injection attacks
 * 
 * Digunakan pada: Global web middleware
 * Performance: Optimized dengan pattern caching
 */
class RequestSanitizerMiddleware
{
    /**
     * Suspicious patterns cache untuk menghindari recomputation
     */
    private static ?array $suspiciousPatterns = null;
    private static ?array $safeRoutes = null;
    private static ?array $threatSeverity = null;

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip sanitization for safe routes
        if ($this->isSafeRoute($request)) {
            return $next($request);
        }

        // Get request data untuk analisis
        $requestData = $this->getRequestData($request);

        // Check for suspicious patterns
        if ($threat = $this->detectThreat($requestData, $request)) {
            $this->logThreat($threat, $request);
            return $this->blockRequest($threat['type']);
        }

        return $next($request);
    }

    /**
     * Check if route is safe dan tidak perlu sanitization
     */
    private function isSafeRoute(Request $request): bool
    {
        if (self::$safeRoutes === null) {
            self::$safeRoutes = config('security.safe_routes', []);
        }

        $path = $request->path();

        // Explicit homepage check (DO NOT add empty string to $safeRoutes – it would bypass all checks)
        if ($path === '' || $path === '/') {
            return true;
        }

        foreach (self::$safeRoutes as $route) {
            if ($route !== '' && str_starts_with($path, $route)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract request data untuk analysis
     */
    private function getRequestData(Request $request): string
    {
        $data = '';

        // URL parameters
        if ($request->getQueryString()) {
            $data .= ' ' . $request->getQueryString();
        }

        // POST data (limit untuk performance)
        if ($request->getContent()) {
            $data .= ' ' . substr($request->getContent(), 0, 5000);
        }

        // Headers yang penting
        $data .= ' ' . ($request->header('User-Agent') ?? '');
        $data .= ' ' . ($request->header('Referer') ?? '');

        return strtolower(trim($data));
    }

    /**
     * Detect threats dalam request data
     */
    private function detectThreat(string $data, Request $request): ?array
    {
        if (self::$suspiciousPatterns === null) {
            self::$suspiciousPatterns = config('security.threat_patterns', []);
        }

        foreach (self::$suspiciousPatterns as $type => $patterns) {
            foreach ($patterns as $pattern) {
                if (strpos($data, strtolower($pattern)) !== false) {
                    return [
                        'type' => $type,
                        'pattern' => $pattern,
                        'severity' => $this->getThreatSeverity($type)
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Get threat severity level
     */
    private function getThreatSeverity(string $type): string
    {
        if (self::$threatSeverity === null) {
            self::$threatSeverity = config('security.threat_severity', []);
        }

        return self::$threatSeverity[$type] ?? 'low';
    }

    /**
     * Log detected threat
     */
    private function logThreat(array $threat, Request $request): void
    {
        $logLevel = $threat['severity'] === 'critical' ? 'critical' : 'warning';

        Log::$logLevel('SECURITY: Request threat detected', [
            'threat_type' => $threat['type'],
            'pattern' => $threat['pattern'],
            'severity' => $threat['severity'],
            'ip' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);
    }

    /**
     * Block request berdasarkan threat type
     */
    private function blockRequest(string $threatType): Response
    {
        return match ($threatType) {
            'sql', 'command', 'inclusion' => abort(403, 'Forbidden'),
            'path' => abort(404, 'Not Found'),
            'xss' => abort(400, 'Bad Request'),
            default => abort(400, 'Bad Request')
        };
    }
}
