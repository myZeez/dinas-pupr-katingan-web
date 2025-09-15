<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Super Admin Access Middleware
 * 
 * Memvalidasi bahwa user yang mengakses adalah super_admin.
 * Middleware ini HANYA untuk route admin, bukan global.
 * 
 * Digunakan pada: Admin route group only
 * Performance: Database query minimal dengan Auth facade
 */
class SuperAdminMiddleware
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check jika user sudah authenticated
        if (!Auth::check()) {
            $this->logUnauthorizedAccess($request, 'unauthenticated');

            return redirect()->route('login')
                ->with('error', 'Silakan login untuk mengakses area admin.');
        }

        $user = Auth::user();

        // Check role super_admin
        if ($user->role !== 'super_admin') {
            $this->logUnauthorizedAccess($request, 'insufficient_privileges', $user);

            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke area admin.');
        }

        // Log successful admin access (hanya di development)
        if (app()->environment('local')) {
            Log::info('Admin access granted', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'path' => $request->path(),
                'ip' => $request->ip()
            ]);
        }

        return $next($request);
    }

    /**
     * Log unauthorized access attempts
     */
    private function logUnauthorizedAccess(Request $request, string $reason, $user = null): void
    {
        $logData = [
            'reason' => $reason,
            'ip' => $request->ip(),
            'path' => $request->path(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ];

        if ($user) {
            $logData['user_id'] = $user->id;
            $logData['user_role'] = $user->role;
        }

        Log::warning('SECURITY: Unauthorized admin access attempt', $logData);
    }
}
