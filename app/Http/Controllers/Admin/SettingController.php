<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SettingController extends Controller
{
    public function index()
    {
        // Only Super Admin can access settings
        if (!Auth::user() || !Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Hanya Super Admin yang dapat mengakses pengaturan sistem.');
        }

        $mailSettings = Setting::where('group', 'mail')->get();
        $user = Auth::user();
        return view('admin.settings.index', compact('mailSettings', 'user'));
    }

    public function updateMail(Request $request)
    {
        // Only Super Admin can update mail settings
        if (!Auth::user() || !Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Hanya Super Admin yang dapat mengubah pengaturan email.');
        }

        $validator = Validator::make($request->all(), [
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|email',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|in:tls,ssl,null',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update settings in database
            Setting::set('mail_mailer', $request->mail_mailer, 'string', 'mail');
            Setting::set('mail_host', $request->mail_host, 'string', 'mail');
            Setting::set('mail_port', $request->mail_port, 'integer', 'mail');
            Setting::set('mail_username', $request->mail_username, 'string', 'mail');
            Setting::set('mail_password', $request->mail_password, 'string', 'mail');
            Setting::set('mail_encryption', $request->mail_encryption, 'string', 'mail');
            Setting::set('mail_from_address', $request->mail_from_address, 'string', 'mail');
            Setting::set('mail_from_name', $request->mail_from_name, 'string', 'mail');

            // Also update .env file for consistency
            $this->updateEnvFile([
                'MAIL_MAILER' => $request->mail_mailer,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => '"' . $request->mail_from_address . '"',
                'MAIL_FROM_NAME' => '"' . $request->mail_from_name . '"'
            ]);

            // Clear config cache to reload settings
            Artisan::call('config:clear');

            return redirect()->back()->with('success', 'Pengaturan email berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Update mail settings error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }

    public function testMail(Request $request)
    {
        // Ensure we return JSON response
        $request->headers->set('Accept', 'application/json');

        try {
            $validator = Validator::make($request->all(), [
                'test_email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak valid: ' . $validator->errors()->first()
                ], 422);
            }

            // Get email settings from database (these will be loaded by SettingServiceProvider)
            $mailHost = Setting::get('mail_host');
            $mailUsername = Setting::get('mail_username');
            $mailPassword = Setting::get('mail_password');
            $mailPort = Setting::get('mail_port');
            $mailEncryption = Setting::get('mail_encryption');

            // Validate that settings exist
            if (!$mailHost || !$mailUsername || !$mailPassword) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi email belum lengkap. Silakan lengkapi pengaturan terlebih dahulu.'
                ], 400);
            }

            // Log current configuration for debugging
            Log::info('Testing email with config:', [
                'host' => $mailHost,
                'port' => $mailPort,
                'username' => $mailUsername,
                'encryption' => $mailEncryption,
                'test_email' => $request->test_email
            ]);

            // Try to send test email
            Mail::raw('Test email dari sistem Dinas PUPR Katingan. Jika Anda menerima email ini, konfigurasi email sudah benar!', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('Test Email - Dinas PUPR Katingan');
            });

            Log::info('Test email sent successfully to: ' . $request->test_email);

            return response()->json([
                'success' => true,
                'message' => 'Email test berhasil dikirim! Silakan cek inbox email ' . $request->test_email
            ]);
        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
            $errorMessage = $e->getMessage();
            Log::error('SMTP Transport error: ' . $errorMessage);

            // Check for specific Gmail errors
            if (strpos($errorMessage, 'Connection to') !== false && strpos($errorMessage, 'has been closed unexpectedly') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koneksi SMTP terputus. Kemungkinan penyebab: Password aplikasi salah, akun Gmail tidak mengizinkan aplikasi kurang aman, atau firewall memblokir koneksi.'
                ], 500);
            }

            if (strpos($errorMessage, 'Invalid credentials') !== false || strpos($errorMessage, 'Authentication failed') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autentikasi gagal. Pastikan email dan password aplikasi Gmail sudah benar.'
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error SMTP: ' . $errorMessage
            ], 500);
        } catch (\Exception $e) {
            Log::error('Test mail error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateEnvFile(array $data)
    {
        $envFile = base_path('.env');

        if (!file_exists($envFile)) {
            return false;
        }

        // Create backup of .env file
        $backupFile = base_path('.env.backup.' . date('Y-m-d_H-i-s'));
        copy($envFile, $backupFile);

        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            // Check if the key exists in the .env file
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                // Add new key at the end
                $envContent .= "\n{$key}={$value}";
            }
        }

        return file_put_contents($envFile, $envContent);
    }

    // Update User Profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    // Update User Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }

    public function updateCaptcha(Request $request)
    {
        // Only Super Admin can update CAPTCHA settings
        if (!Auth::user() || !Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Hanya Super Admin yang dapat mengubah pengaturan CAPTCHA.');
        }

        $validator = Validator::make($request->all(), [
            'captcha_required' => 'nullable|boolean',
            'nocaptcha_sitekey' => 'required|string',
            'nocaptcha_secret' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update CAPTCHA settings using CaptchaSetting model
            \App\Models\CaptchaSetting::setValue('captcha_required', $request->boolean('captcha_required'));
            \App\Models\CaptchaSetting::setValue('nocaptcha_sitekey', $request->nocaptcha_sitekey);
            \App\Models\CaptchaSetting::setValue('nocaptcha_secret', $request->nocaptcha_secret);

            // Clear configuration cache
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return redirect()->back()->with('captcha_success', 'Pengaturan CAPTCHA berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('CAPTCHA settings update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['captcha_error' => 'Gagal memperbarui pengaturan CAPTCHA: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function testCaptcha(Request $request)
    {
        // Only Super Admin can test CAPTCHA
        if (!Auth::user() || !Auth::user()->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Super Admin yang dapat melakukan test CAPTCHA'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'site_key' => 'required|string',
            'secret_key' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Site Key dan Secret Key diperlukan untuk test'
            ]);
        }

        try {
            // First, try basic key format validation
            if (strlen($request->site_key) < 30 || strlen($request->secret_key) < 30) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format key tidak valid. Site key dan Secret key harus minimal 30 karakter'
                ]);
            }

            // Check if keys start with proper prefixes
            if (!str_starts_with($request->site_key, '6L') || !str_starts_with($request->secret_key, '6L')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format key tidak valid. reCAPTCHA keys harus dimulai dengan "6L"'
                ]);
            }

            // Test CAPTCHA keys using Google API with SSL configuration
            $client = new \GuzzleHttp\Client([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
                'connect_timeout' => 10,
                'http_errors' => false // Don't throw exceptions on HTTP errors
            ]);

            // Create a dummy verification request to test the keys
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => $request->secret_key,
                    'response' => 'test-token' // This will fail but will validate if keys are properly formatted
                ],
                'headers' => [
                    'User-Agent' => 'PUPR-Web/1.0',
                    'Accept' => 'application/json'
                ]
            ]);

            // Check if request was successful
            if ($response->getStatusCode() !== 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghubungi Google reCAPTCHA API. Status: ' . $response->getStatusCode()
                ]);
            }

            $result = json_decode($response->getBody()->getContents(), true);

            // Check if we got valid JSON response
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Response dari Google API tidak valid'
                ]);
            }

            // If we get a response (even if error), it means the secret key format is correct
            if (isset($result['error-codes'])) {
                // Check if error is about invalid input (which is expected for our test)
                if (
                    in_array('invalid-input-response', $result['error-codes']) ||
                    in_array('timeout-or-duplicate', $result['error-codes'])
                ) {
                    return response()->json([
                        'success' => true,
                        'message' => 'CAPTCHA keys valid! Format kunci sudah benar dan dapat berkomunikasi dengan Google reCAPTCHA API'
                    ]);
                }

                // Check for key format errors
                if (in_array('invalid-input-secret', $result['error-codes'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Secret Key tidak valid atau format salah'
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'CAPTCHA keys berhasil diverifikasi dengan Google API'
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            // If SSL/connection fails, do offline validation
            if (strpos($e->getMessage(), 'SSL certificate') !== false || strpos($e->getMessage(), 'cURL error 60') !== false) {
                Log::warning('SSL error during CAPTCHA test, falling back to offline validation: ' . $e->getMessage());

                // Perform offline validation
                return $this->performOfflineCaptchaValidation($request->site_key, $request->secret_key);
            }

            Log::error('CAPTCHA test connection failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke Google reCAPTCHA API. Periksa koneksi internet Anda'
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('CAPTCHA test request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Request error: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Log::error('CAPTCHA test general error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat testing CAPTCHA: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Perform offline CAPTCHA validation when API connection fails
     */
    private function performOfflineCaptchaValidation($siteKey, $secretKey)
    {
        // Basic format validation
        $errors = [];

        // Check site key format
        if (!preg_match('/^6L[a-zA-Z0-9_-]{38}$/', $siteKey)) {
            $errors[] = 'Site Key format tidak valid';
        }

        // Check secret key format
        if (!preg_match('/^6L[a-zA-Z0-9_-]{38}$/', $secretKey)) {
            $errors[] = 'Secret Key format tidak valid';
        }

        // Check if keys are different
        if ($siteKey === $secretKey) {
            $errors[] = 'Site Key dan Secret Key tidak boleh sama';
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi offline gagal: ' . implode(', ', $errors)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => '✅ Validasi offline berhasil! Format key sudah benar. (Koneksi API tidak tersedia - SSL issue)'
        ]);
    }
}
