<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid'
        ]);

        try {
            // Cek apakah email ada di database
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'Email tidak terdaftar dalam sistem.'
                ]);
            }

            // Cek apakah user adalah admin
            if ($user->role !== 'super_admin') {
                throw ValidationException::withMessages([
                    'email' => 'Email tidak memiliki akses administrator.'
                ]);
            }

            // Generate password baru
            $newPassword = $this->generateSecurePassword();

            // Update password di database
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            // Kirim email dengan password baru
            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'newPassword' => $newPassword,
                'loginUrl' => route('login'),
                'timestamp' => now()->format('d/m/Y H:i:s')
            ];

            // Log email data untuk debugging
            Log::info('Preparing to send password reset email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_from' => config('mail.from.address')
            ]);

            try {
                Mail::send('emails.password-reset', $emailData, function ($message) use ($user) {
                    $message->to($user->email, $user->name)
                        ->subject('Reset Password Admin - Dinas PUPR');
                });

                Log::info('Password reset email sent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send password reset email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'mail_error' => $mailException->getMessage(),
                    'mail_trace' => $mailException->getTraceAsString()
                ]);

                throw new \Exception('Gagal mengirim email: ' . $mailException->getMessage());
            }

            // Log aktivitas
            Log::info('Password reset email sent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);

            return redirect()->route('login')
                ->with('success', 'Password baru telah dikirim ke email Anda. Silakan cek email dan login dengan password baru.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password reset failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }
    }

    /**
     * Generate secure random password
     */
    private function generateSecurePassword($length = 12)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*';

        $password = '';

        // Pastikan ada minimal 1 karakter dari setiap kategori
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Isi sisa karakter secara random
        $allChars = $lowercase . $uppercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Acak urutan karakter
        return str_shuffle($password);
    }
}
