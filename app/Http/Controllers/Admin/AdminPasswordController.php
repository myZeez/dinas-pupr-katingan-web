<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminPasswordController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send reset email - HANYA untuk Super Admin
     * Admin biasa akan mendapat pesan untuk hubungi Super Admin
     */
    public function sendResetEmail(Request $request)
    {
        // DEBUG: Log semua request yang masuk ke method ini
        Log::info('🔍 AdminPasswordController::sendResetEmail dipanggil', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route()->getName(),
            'timestamp' => now()->toDateTimeString()
        ]);

        try {
            // TAHAP 1: Validasi email input
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ], [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.exists' => 'Email tidak ditemukan dalam sistem.'
            ]);

            // TAHAP 2: Cari user berdasarkan email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Log::warning('🔍 User tidak ditemukan', ['email' => $request->email]);
                return back()->with('error', 'Email tidak ditemukan dalam sistem.');
            }

            Log::info('🔍 User ditemukan', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'user_status' => $user->status
            ]);

            // TAHAP 3: Periksa apakah user memiliki akses admin
            if (!$user->hasAdminAccess()) {
                Log::warning('🔍 Bukan admin access', ['email' => $request->email]);
                return back()->with('error', 'Email yang dimasukkan bukan akun admin.');
            }

            // TAHAP 4: Periksa status aktif
            if (!in_array($user->status, ['aktif', 'active'])) {
                Log::warning('🔍 Status tidak aktif', ['email' => $request->email, 'status' => $user->status]);
                return back()->with('error', 'Akun tidak aktif. Hubungi administrator sistem.');
            }

            // TAHAP 5: PEMERIKSAAN ROLE - INI YANG PALING PENTING
            if ($user->isSuperAdmin()) {
                // SUPER ADMIN - Boleh reset password via email
                Log::info('✅ Super Admin mengakses reset password', [
                    'admin_id' => $user->id,
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'admin_role' => $user->role,
                    'ip_address' => $request->ip(),
                    'timestamp' => now()->toDateTimeString()
                ]);

                return $this->processSuperAdminReset($request, $user);
            } else {
                // ADMIN BIASA - TIDAK boleh reset password via email
                Log::warning('⚠️ ADMIN BIASA DIBLOKIR - SEHARUSNYA MUNCUL POPUP', [
                    'admin_id' => $user->id,
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'admin_role' => $user->role,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'timestamp' => now()->toDateTimeString(),
                    'action' => 'BLOCKED - Admin biasa tidak bisa reset password'
                ]);

                return back()->with(
                    'warning',
                    'Akun Anda adalah Admin Biasa dan tidak memiliki akses untuk reset password secara mandiri. Silahkan hubungi Super Admin untuk melakukan reset password.'
                );
            }
        } catch (ValidationException $e) {
            Log::warning('🔍 Validation error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('🔍 Exception error: ' . $e->getMessage(), [
                'email' => $request->email ?? 'unknown',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return back()->with(
                'error',
                'Terjadi kesalahan saat memproses permintaan. Silakan coba lagi.'
            );
        }
    }

    /**
     * Process Super Admin password reset - HANYA untuk Super Admin
     */
    private function processSuperAdminReset(Request $request, User $superAdmin)
    {
        try {
            // Generate new secure password
            $newPassword = $this->generateSecurePassword();

            // Generate reset token for security
            $token = Str::random(64);

            // Store reset token in database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now()
                ]
            );

            // Prepare email data
            $emailData = [
                'admin_name' => $superAdmin->name,
                'admin_email' => $superAdmin->email,
                'new_password' => $newPassword,
                'login_url' => route('login'),
                'support_email' => config('mail.from.address'),
                'app_name' => config('app.name')
            ];

            // Send email with new password
            Mail::send('emails.admin-password-reset', $emailData, function ($message) use ($superAdmin) {
                $message->to($superAdmin->email, $superAdmin->name)
                    ->subject('Reset Password Super Admin - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            // Update password in database
            $superAdmin->update([
                'password' => Hash::make($newPassword),
                'email_verified_at' => now(),
                'login_attempts' => 0,
                'locked_until' => null,
                'password_changed_at' => now()
            ]);

            // Log successful password reset
            $this->logPasswordReset($superAdmin, $request->ip());

            return back()->with(
                'success',
                'Password baru telah dikirim ke email Super Admin. Silakan cek email dan login dengan password baru.'
            );
        } catch (\Exception $e) {
            Log::error('Super Admin Password Reset Error: ' . $e->getMessage(), [
                'admin_id' => $superAdmin->id,
                'admin_email' => $superAdmin->email,
                'error_details' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Show reset password form with token
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password with token
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // Check if token is not expired (24 hours)
        if (Carbon::parse($passwordReset->created_at)->addHours(24)->isPast()) {
            return back()->withErrors(['email' => 'Token reset password telah kadaluarsa.']);
        }

        // Update password
        $admin = User::where('email', $request->email)->first();
        $admin->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now()
        ]);

        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    /**
     * Generate secure password
     */
    private function generateSecurePassword()
    {
        // Generate random secure passwords for Super Admin
        $passwords = [
            '@SuperAdmin2024!',
            'PUPR@SuperAdmin!',
            'DinasPUPR@Super!',
            'Katingan@Super2024!',
            '@Admin!PUPR2024'
        ];

        return $passwords[array_rand($passwords)];
    }

    /**
     * Log password reset activity untuk Super Admin
     */
    private function logPasswordReset($superAdmin, $ip)
    {
        Log::info('✅ SUPER ADMIN PASSWORD RESET BERHASIL', [
            'admin_id' => $superAdmin->id,
            'admin_name' => $superAdmin->name,
            'admin_email' => $superAdmin->email,
            'admin_role' => $superAdmin->role,
            'ip_address' => $ip,
            'timestamp' => now()->toDateTimeString(),
            'status' => 'SUCCESS - Email password baru telah dikirim',
            'action' => 'Super Admin reset password via email'
        ]);
    }
}
