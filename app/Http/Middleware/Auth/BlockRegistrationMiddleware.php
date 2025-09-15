<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registration Block Middleware
 * 
 * Memblokir semua akses ke route registrasi publik.
 * Hanya admin yang dapat membuat user baru melalui panel admin.
 * 
 * Digunakan pada: Registration routes only
 * Performance: Minimal, hanya path checking
 */
class BlockRegistrationMiddleware
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log attempt
        Log::warning('SECURITY: Registration access blocked', [
            'ip' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        // Return 404 untuk menyembunyikan eksistensi route
        abort(404, 'Page not found');
    }
}
