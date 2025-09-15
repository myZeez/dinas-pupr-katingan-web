<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 * 
 * Menambahkan HTTP security headers untuk proteksi browser-level:
 * - XSS Protection
 * - Content Type Protection
 * - Frame Options (Clickjacking protection)
 * - Content Security Policy
 * - HSTS (HTTPS Strict Transport Security)
 * 
 * Digunakan pada: Global web middleware
 * Performance: Minimal impact, headers only
 */
class SecurityHeadersMiddleware
{
    /**
     * Security headers configuration
     */
    private const SECURITY_HEADERS = [
        // XSS Protection
        'X-XSS-Protection' => '1; mode=block',

        // Content Type Protection
        'X-Content-Type-Options' => 'nosniff',

        // Frame Options (Clickjacking Protection)
        'X-Frame-Options' => 'DENY',

        // Referrer Policy
        'Referrer-Policy' => 'strict-origin-when-cross-origin',

        // Feature Policy
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=()',
    ];

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Apply security headers
        foreach (self::SECURITY_HEADERS as $header => $value) {
            $response->headers->set($header, $value);
        }

        // HTTPS Strict Transport Security (hanya untuk HTTPS)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Content Security Policy (disesuaikan dengan kebutuhan app)
        $csp = $this->getContentSecurityPolicy($request);
        if ($csp) {
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Server identification hiding
        $response->headers->remove('Server');
        $response->headers->remove('X-Powered-By');

        return $response;
    }

    /**
     * Generate Content Security Policy berdasarkan environment
     */
    private function getContentSecurityPolicy(Request $request): string
    {
        $isProduction = app()->environment('production');

        // Base CSP dengan dukungan CDN untuk Bootstrap, Google Fonts, dan Bunny Fonts
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net unpkg.com",
            "style-src 'self' 'unsafe-inline' fonts.googleapis.com fonts.bunny.net cdn.jsdelivr.net unpkg.com",
            "font-src 'self' fonts.gstatic.com fonts.bunny.net cdn.jsdelivr.net",
            "img-src 'self' data: blob: *", // Allow all image sources for flexibility
            "connect-src 'self'",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'"
        ];

        // Development environment - lebih permissive
        if (!$isProduction) {
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net unpkg.com localhost:* 127.0.0.1:*",
                "style-src 'self' 'unsafe-inline' fonts.googleapis.com fonts.bunny.net cdn.jsdelivr.net unpkg.com",
                "font-src 'self' fonts.gstatic.com fonts.bunny.net cdn.jsdelivr.net",
                "img-src 'self' data: blob: *",
                "connect-src 'self' ws: wss: localhost:* 127.0.0.1:*",
                "frame-src 'none'",
                "object-src 'none'",
                "base-uri 'self'"
            ];
        }

        return implode('; ', $csp);
    }
}
