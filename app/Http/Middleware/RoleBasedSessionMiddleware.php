<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to authenticated users
        if (Auth::check()) {
            $user = Auth::user();

            // Create role-specific session identifier
            $rolePrefix = match ($user->role) {
                'super_admin' => 'sa_',
                'admin' => 'admin_',
                default => 'user_'
            };

            // Set role-specific session name
            $sessionName = config('session.cookie') . '_' . $rolePrefix . $user->id;

            // Store original session name
            if (!session()->has('original_session_name')) {
                session(['original_session_name' => config('session.cookie')]);
            }

            // Set custom session name for this role
            config(['session.cookie' => $sessionName]);
        }

        return $next($request);
    }
}
