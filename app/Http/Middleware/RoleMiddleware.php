<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        // Check if user status is active
        if ($user->status !== 'active') {
            Auth::logout();
            $statusMessage = match ($user->status) {
                'inactive' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                'suspended' => 'Akun Anda telah disuspend. Silakan hubungi administrator.',
                default => 'Akun Anda tidak dapat diakses. Silakan hubungi administrator.'
            };

            return redirect()->route('login')->with('error', $statusMessage);
        }

        // Check if user account is locked
        if ($user->locked_until && $user->locked_until > now()) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda terkunci. Silakan coba lagi nanti atau hubungi administrator.');
        }

        // Check roles
        if (!empty($roles)) {
            $hasAccess = false;

            foreach ($roles as $role) {
                switch ($role) {
                    case 'super_admin':
                        if ($user->isSuperAdmin()) {
                            $hasAccess = true;
                        }
                        break;
                    case 'admin':
                        if ($user->isAdmin()) {
                            $hasAccess = true;
                        }
                        break;
                    case 'any_admin':
                        if ($user->hasAdminAccess()) {
                            $hasAccess = true;
                        }
                        break;
                }

                if ($hasAccess) break;
            }

            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}
