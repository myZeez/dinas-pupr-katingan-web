<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Get user and trigger login event for session management
        $user = Auth::user();

        // Fire login event to update session with role
        event(new \Illuminate\Auth\Events\Login('web', $user, false));

        // Update last login timestamp
        $user->update(['last_login_at' => now()]);

        Session::regenerate();

        // Redirect based on user role
        if ($user->hasAdminAccess()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // For regular users, redirect to home page
        return redirect()->intended(route('public.home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
