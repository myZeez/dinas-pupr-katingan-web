<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // PEMBATASAN: Cek apakah email ini adalah admin
        $user = User::where('email', $request->email)->first();

        if ($user && $user->hasAdminAccess()) {
            // Jika admin, redirect ke halaman admin forgot password dengan pesan
            return redirect()->route('admin.password.request')
                ->with('info', 'Untuk reset password admin, silakan gunakan halaman khusus admin ini.')
                ->withInput(['email' => $request->email]);
        }

        // Jika bukan admin, lanjutkan dengan proses normal
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
