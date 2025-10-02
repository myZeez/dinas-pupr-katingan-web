<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use App\Models\User;
use App\Mail\PengaduanNotification;
use App\Services\CaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PublicPengaduanController extends Controller
{
    /**
     * Store a newly created pengaduan from public form.
     */
    public function store(Request $request)
    {
        Log::info('PublicPengaduanController store method called', [
            'request_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            // CAPTCHA verification
            $captchaService = new CaptchaService();
            if ($captchaService->isRequired()) {
                if (!$captchaService->verify($request->input('g-recaptcha-response'), $request)) {
                    $errorMessage = 'Verifikasi CAPTCHA gagal. Silakan coba lagi.';

                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => $errorMessage,
                            'errors' => ['captcha' => [$errorMessage]]
                        ], 422);
                    }

                    return redirect()->back()
                        ->withErrors(['captcha' => $errorMessage])
                        ->withInput();
                }
            }

            // Check which form format is being used
            $isKontakForm = $request->has('judul') && $request->has('isi_pengaduan');

            // Validation rules - support both form formats
            if ($isKontakForm) {
                // Kontak page form validation
                $validator = Validator::make($request->all(), [
                    'nama' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'no_hp' => 'nullable|string|max:20',
                    'judul' => 'required|string|max:255',
                    'isi_pengaduan' => 'required|string',
                    'g-recaptcha-response' => 'required_if:' . ($captchaService->isRequired() ? 'true' : 'false') . ',true',
                ], [
                    'nama.required' => 'Nama lengkap wajib diisi.',
                    'email.required' => 'Email wajib diisi.',
                    'email.email' => 'Format email tidak valid.',
                    'judul.required' => 'Judul pengaduan wajib diisi.',
                    'isi_pengaduan.required' => 'Isi pengaduan wajib diisi.',
                    'g-recaptcha-response.required_if' => 'Verifikasi CAPTCHA wajib dilengkapi.',
                ]);
            } else {
                // Modal form validation
                $validator = Validator::make($request->all(), [
                    'nama' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'telepon' => 'nullable|string|max:20',
                    'kategori' => 'required|string|max:255',
                    'pesan' => 'required|string',
                    'g-recaptcha-response' => 'required_if:' . ($captchaService->isRequired() ? 'true' : 'false') . ',true',
                ], [
                    'nama.required' => 'Nama lengkap wajib diisi.',
                    'email.required' => 'Email wajib diisi.',
                    'email.email' => 'Format email tidak valid.',
                    'kategori.required' => 'Kategori pengaduan wajib diisi.',
                    'pesan.required' => 'Pesan pengaduan wajib diisi.',
                    'g-recaptcha-response.required_if' => 'Verifikasi CAPTCHA wajib dilengkapi.',
                ]);
            }

            if ($validator->fails()) {
                Log::warning('PublicPengaduanController validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                // Check if request is AJAX
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data yang Anda masukkan tidak valid.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Create pengaduan - handle both form formats
            $pengaduanData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $isKontakForm ? $request->no_hp : $request->telepon,
                'kategori' => $isKontakForm ? $request->judul : $request->kategori, // FIXED: Use 'kategori' column
                'pesan' => $isKontakForm ? $request->isi_pengaduan : $request->pesan,
                'status' => 'Baru', // FIXED: Use correct enum value
                'tanggal_pengaduan' => now()
            ];

            Log::info('Creating pengaduan with data:', $pengaduanData);

            $pengaduan = Pengaduan::create($pengaduanData);

            Log::info('Pengaduan created successfully', [
                'pengaduan_id' => $pengaduan->id,
                'pengaduan_data' => $pengaduan->toArray()
            ]);

            // Create history record for initial creation
            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'status_from' => null,
                'status_to' => 'Baru', // FIXED: Use correct enum value
                'action' => 'Dibuat',
                'keterangan' => 'Pengaduan baru dibuat oleh masyarakat melalui website',
                'admin_name' => 'Sistem',
                'admin_email' => 'system@pupr.com'
            ]);

            Log::info('Pengaduan history created for initial status');

            // Send email notification to admin
            try {
                $this->sendSimpleEmailNotification($pengaduan);
            } catch (\Exception $mailError) {
                Log::error('Failed to send pengaduan notification email', [
                    'pengaduan_id' => $pengaduan->id,
                    'error' => $mailError->getMessage()
                ]);
                // Don't fail the request if email fails, just log it
            }

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengaduan Anda berhasil dikirim. Terima kasih!',
                    'data' => [
                        'id' => $pengaduan->id,
                        'status' => 'success'
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Pengaduan Anda berhasil dikirim. Terima kasih!');
        } catch (\Exception $e) {
            Log::error('PublicPengaduanController store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Check method for testing (optional)
     */
    public function check()
    {
        Log::info('PublicPengaduanController check method called');

        $totalPengaduan = Pengaduan::count();
        $latestPengaduan = Pengaduan::latest()->first();

        return response()->json([
            'message' => 'PublicPengaduanController is working',
            'total_pengaduan' => $totalPengaduan,
            'latest_pengaduan' => $latestPengaduan,
            'timestamp' => now()
        ]);
    }

    /**
     * Get admin email addresses for notifications
     */
    private function getAdminEmails()
    {
        try {
            // Get admin and super admin users
            $adminEmails = User::whereIn('role', ['admin', 'super_admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->values()
                ->toArray();

            // Fallback to default admin email if no admin users found
            if (empty($adminEmails)) {
                $fallbackEmails = [
                    env('ADMIN_EMAIL', 'admin@puprkatingan.go.id'),
                    'info@puprkatingan.go.id'
                ];

                return array_filter($fallbackEmails, function ($email) {
                    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                });
            }

            return $adminEmails;
        } catch (\Exception $e) {
            Log::error('Error getting admin emails', [
                'error' => $e->getMessage()
            ]);

            // Return fallback emails
            return [
                env('ADMIN_EMAIL', 'admin@puprkatingan.go.id')
            ];
        }
    }

    /**
     * Send email with fallback to log driver if SMTP fails
     */
    private function sendEmailWithFallback($adminEmails, $mailable, $pengaduanId = null)
    {
        $originalDriver = config('mail.default');
        $emailsSent = [];
        $emailsFailed = [];

        foreach ($adminEmails as $adminEmail) {
            try {
                // Try sending with current mail driver (probably SMTP)
                config(['mail.default' => $originalDriver]);

                Mail::to($adminEmail)->send($mailable);
                $emailsSent[] = $adminEmail;

                Log::info('Email sent successfully via ' . $originalDriver, [
                    'to' => $adminEmail,
                    'pengaduan_id' => $pengaduanId,
                    'driver' => $originalDriver
                ]);
            } catch (\Exception $smtpError) {
                Log::warning('SMTP email failed, trying log fallback', [
                    'to' => $adminEmail,
                    'pengaduan_id' => $pengaduanId,
                    'smtp_error' => $smtpError->getMessage()
                ]);

                try {
                    // Fallback to log driver
                    config(['mail.default' => 'log']);

                    Mail::to($adminEmail)->send($mailable);
                    $emailsFailed[] = $adminEmail . ' (logged)';

                    Log::info('Email logged successfully as fallback', [
                        'to' => $adminEmail,
                        'pengaduan_id' => $pengaduanId,
                        'original_error' => $smtpError->getMessage()
                    ]);
                } catch (\Exception $logError) {
                    $emailsFailed[] = $adminEmail . ' (completely failed)';
                    Log::error('Both SMTP and log email failed', [
                        'to' => $adminEmail,
                        'pengaduan_id' => $pengaduanId,
                        'smtp_error' => $smtpError->getMessage(),
                        'log_error' => $logError->getMessage()
                    ]);
                }
            }
        }

        // Restore original mail driver
        config(['mail.default' => $originalDriver]);

        // Log summary
        if (!empty($emailsSent)) {
            Log::info('Pengaduan notification emails sent successfully', [
                'pengaduan_id' => $pengaduanId,
                'emails_sent' => $emailsSent
            ]);
        }

        if (!empty($emailsFailed)) {
            Log::warning('Some pengaduan notification emails failed', [
                'pengaduan_id' => $pengaduanId,
                'emails_failed' => $emailsFailed
            ]);
        }

        return [
            'sent' => $emailsSent,
            'failed' => $emailsFailed
        ];
    }

    /**
     * Send simple email notification - Laravel style like password reset
     */
    private function sendSimpleEmailNotification($pengaduan)
    {
        try {
            // Get admin emails
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin emails found', ['pengaduan_id' => $pengaduan->id]);
                return;
            }

            // Prepare email content
            $subject = "🚨 Pengaduan Baru: {$pengaduan->kategori}";

            // HTML Content
            $htmlContent = $this->getEmailHtmlContent($pengaduan);

            // Text Content (fallback)
            $textContent = $this->getEmailTextContent($pengaduan);

            // Send to each admin
            foreach ($adminEmails as $email) {
                $this->sendToAdmin($email, $subject, $htmlContent, $textContent, $pengaduan->id);
            }
        } catch (\Exception $e) {
            Log::error('Email notification failed', [
                'pengaduan_id' => $pengaduan->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email to single admin with fallback
     */
    private function sendToAdmin($email, $subject, $htmlContent, $textContent, $pengaduanId)
    {
        try {
            // Try SMTP first (like password reset)
            Mail::send([], [], function ($message) use ($email, $subject, $htmlContent) {
                $message->to($email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan')
                    ->html($htmlContent);
            });

            Log::info('Email sent via SMTP', ['to' => $email, 'pengaduan_id' => $pengaduanId]);
        } catch (\Exception $e) {
            // SMTP failed, use log fallback
            try {
                $originalDriver = config('mail.default');
                config(['mail.default' => 'log']);

                Mail::raw($textContent, function ($mail) use ($email, $subject) {
                    $mail->to($email)->subject($subject);
                });

                config(['mail.default' => $originalDriver]);

                Log::info('Email fallback to log', [
                    'to' => $email,
                    'pengaduan_id' => $pengaduanId,
                    'smtp_error' => $e->getMessage()
                ]);
            } catch (\Exception $e2) {
                Log::error('All email methods failed', [
                    'to' => $email,
                    'pengaduan_id' => $pengaduanId,
                    'smtp_error' => $e->getMessage(),
                    'log_error' => $e2->getMessage()
                ]);
            }
        }
    }

    /**
     * Get HTML email content
     */
    private function getEmailHtmlContent($pengaduan)
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f9fa;'>
            <div style='background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #2E8B57; margin-bottom: 20px; text-align: center; border-bottom: 3px solid #2E8B57; padding-bottom: 15px;'>
                    🚨 PENGADUAN BARU
                </h2>

                <div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                    <h3 style='color: #2E8B57; margin: 0;'>PUPR KATINGAN</h3>
                    <p style='color: #666; margin: 5px 0 0 0;'>Sistem Pengaduan Online</p>
                </div>

                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold; width: 25%;'>Nama</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>{$pengaduan->nama}</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Email</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>
                            <a href='mailto:{$pengaduan->email}' style='color: #007bff; text-decoration: none;'>{$pengaduan->email}</a>
                        </td>
                    </tr>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>No. Telepon</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>" . ($pengaduan->telepon ?: '-') . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Kategori</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'><strong>{$pengaduan->kategori}</strong></td>
                    </tr>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Waktu</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>" . now()->format('d F Y, H:i') . " WIB</td>
                    </tr>
                </table>

                <div style='margin: 25px 0;'>
                    <h3 style='color: #2E8B57; margin-bottom: 10px;'>💬 Isi Pengaduan:</h3>
                    <div style='background-color: #ffffff; border: 1px solid #dee2e6; border-left: 5px solid #007bff; padding: 20px; border-radius: 5px; white-space: pre-wrap; line-height: 1.6;'>
                        {$pengaduan->pesan}
                    </div>
                </div>

                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . url('/admin/pengaduan') . "'
                       style='background: linear-gradient(135deg, #2E8B57, #20B2AA); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; display: inline-block; font-weight: bold; box-shadow: 0 4px 15px rgba(46,139,87,0.3);'>
                        🔍 Buka Admin Panel
                    </a>
                </div>

                <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 30px; text-align: center;'>
                    <p style='color: #666; font-size: 14px; margin: 0;'>
                        📧 Email otomatis dari <strong>Sistem PUPR Katingan</strong><br>
                        Mohon tidak membalas email ini secara langsung
                    </p>
                </div>
            </div>
        </div>";
    }

    /**
     * Get text email content (fallback)
     */
    private function getEmailTextContent($pengaduan)
    {
        return "
🚨 PENGADUAN BARU - PUPR KATINGAN
===============================

INFORMASI PENGADU:
- Nama: {$pengaduan->nama}
- Email: {$pengaduan->email}
- No. Telepon: " . ($pengaduan->telepon ?: '-') . "
- Kategori: {$pengaduan->kategori}
- Waktu: " . now()->format('d F Y, H:i') . " WIB

INTI PENGADUAN:
{$pengaduan->pesan}

===============================
Untuk menanggapi, silakan buka:
" . url('/admin/pengaduan') . "

Email otomatis dari sistem PUPR Katingan
Jangan balas email ini secara langsung.
        ";
    }
}
