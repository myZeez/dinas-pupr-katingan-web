<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    /**
     * Constructor - Ensure fresh email configuration with cache optimization
     */
    public function __construct()
    {
        // Clear mail configuration cache to ensure fresh config
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        // Force reload configuration from .env without cache
        $this->refreshMailConfig();
    }

    /**
     * Refresh mail configuration from environment
     */
    private function refreshMailConfig()
    {
        // Clear existing config cache
        app('config')->set('mail', null);

        // Reload fresh config from .env
        $mailConfig = [
            'mail.default' => env('MAIL_MAILER', 'smtp'),
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'mail.mailers.smtp.port' => env('MAIL_PORT', 587),
            'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
            'mail.mailers.smtp.password' => env('MAIL_PASSWORD'),
            'mail.mailers.smtp.timeout' => env('MAIL_SMTP_TIMEOUT', 30),
            'mail.from.address' => env('MAIL_FROM_ADDRESS'),
            'mail.from.name' => env('MAIL_FROM_NAME', 'DINAS PUPR KATINGAN'),
        ];

        foreach ($mailConfig as $key => $value) {
            config([$key => $value]);
        }

        // Log configuration for debugging
        if (env('MAIL_DEBUG', false)) {
            Log::info('EmailNotificationService: Mail configuration refreshed', [
                'host' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT'),
                'username' => env('MAIL_USERNAME'),
                'encryption' => env('MAIL_ENCRYPTION')
            ]);
        }
    }

    /**
     * Send pengaduan notification to admin
     */
    public function sendPengaduanNotification(Pengaduan $pengaduan)
    {
        try {
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin emails found for pengaduan notification', [
                    'pengaduan_id' => $pengaduan->id
                ]);
                return false;
            }

            $subject = "🚨 Pengaduan Baru: {$pengaduan->kategori}";
            $htmlContent = $this->buildPengaduanHtmlContent($pengaduan);
            $textContent = $this->buildPengaduanTextContent($pengaduan);

            $success = true;
            foreach ($adminEmails as $email) {
                if (!$this->sendEmailWithFallback($email, $subject, $htmlContent, $textContent, 'pengaduan', $pengaduan->id)) {
                    $success = false;
                }
            }

            return $success;
        } catch (\Exception $e) {
            Log::error('EmailNotificationService: Pengaduan notification failed', [
                'pengaduan_id' => $pengaduan->id ?? 'unknown',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * Send kontak notification to admin
     */
    public function sendKontakNotification($kontakData)
    {
        try {
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin emails found for kontak notification');
                return false;
            }

            $subject = "💬 Pesan Kontak Baru: {$kontakData['subjek']}";
            $htmlContent = $this->buildKontakHtmlContent($kontakData);
            $textContent = $this->buildKontakTextContent($kontakData);

            $success = true;
            foreach ($adminEmails as $email) {
                if (!$this->sendEmailWithFallback($email, $subject, $htmlContent, $textContent, 'kontak')) {
                    $success = false;
                }
            }

            return $success;
        } catch (\Exception $e) {
            Log::error('EmailNotificationService: Kontak notification failed', [
                'kontak_data' => $kontakData,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * Send email with SMTP retry and fallback to log
     */
    private function sendEmailWithFallback($email, $subject, $htmlContent, $textContent, $type = 'notification', $relatedId = null)
    {
        $maxAttempts = env('MAIL_RETRY_ATTEMPTS', 3);
        $retryDelay = env('MAIL_RETRY_DELAY', 1);

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                // Refresh config before each attempt to avoid cache issues
                if ($attempt > 1) {
                    $this->refreshMailConfig();
                    sleep($retryDelay);
                }

                // Try SMTP
                Mail::send([], [], function ($message) use ($email, $subject, $htmlContent) {
                    $message->to($email)
                        ->subject($subject)
                        ->from(config('mail.from.address'), config('mail.from.name') ?: 'PUPR Katingan')
                        ->html($htmlContent);
                });

                Log::info("EmailNotificationService: Email sent successfully via SMTP", [
                    'to' => $email,
                    'type' => $type,
                    'related_id' => $relatedId,
                    'subject' => $subject,
                    'attempt' => $attempt
                ]);

                return true;
            } catch (\Exception $e) {
                $isLastAttempt = ($attempt === $maxAttempts);

                Log::warning("EmailNotificationService: SMTP attempt $attempt failed", [
                    'to' => $email,
                    'type' => $type,
                    'related_id' => $relatedId,
                    'error' => $e->getMessage(),
                    'attempt' => $attempt,
                    'max_attempts' => $maxAttempts
                ]);

                if ($isLastAttempt) {
                    // All SMTP attempts failed, use log fallback
                    return $this->fallbackToLog($email, $subject, $textContent, $type, $relatedId, $e->getMessage());
                }
            }
        }

        return false;
    }

    /**
     * Fallback to log when SMTP fails
     */
    private function fallbackToLog($email, $subject, $textContent, $type, $relatedId, $smtpError)
    {
        try {
            $originalDriver = config('mail.default');
            config(['mail.default' => 'log']);

            Mail::raw($textContent, function ($mail) use ($email, $subject) {
                $mail->to($email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name') ?: 'PUPR Katingan');
            });

            // Restore original driver
            config(['mail.default' => $originalDriver]);

            Log::info('EmailNotificationService: Email logged as fallback', [
                'to' => $email,
                'type' => $type,
                'related_id' => $relatedId,
                'smtp_error' => $smtpError,
                'subject' => $subject
            ]);

            return true;
        } catch (\Exception $e2) {
            Log::error('EmailNotificationService: Both SMTP and log failed', [
                'to' => $email,
                'type' => $type,
                'related_id' => $relatedId,
                'smtp_error' => $smtpError,
                'log_error' => $e2->getMessage(),
                'subject' => $subject
            ]);

            return false;
        }
    }

    /**
     * Get admin emails from database
     */
    private function getAdminEmails()
    {
        try {
            return User::whereIn('role', ['super_admin', 'admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->toArray();
        } catch (\Exception $e) {
            Log::error('EmailNotificationService: Failed to get admin emails', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Build HTML content for pengaduan email
     */
    private function buildPengaduanHtmlContent(Pengaduan $pengaduan)
    {
        $adminUrl = url('/admin/pengaduan');
        $waktu = now()->format('d F Y, H:i');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Pengaduan Baru - PUPR Katingan</title>
        </head>
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;'>

                <!-- Header -->
                <div style='background: linear-gradient(135deg, #2E8B57 0%, #20B2AA 100%); color: white; padding: 30px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 24px; font-weight: bold;'>🚨 PENGADUAN BARU</h1>
                    <p style='margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;'>PUPR Katingan - Sistem Online</p>
                </div>

                <!-- Content -->
                <div style='padding: 30px;'>

                    <!-- Alert Box -->
                    <div style='background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 15px; margin-bottom: 25px;'>
                        <p style='margin: 0; color: #856404; font-weight: bold;'>
                            ⚡ Pengaduan baru memerlukan perhatian segera
                        </p>
                    </div>

                    <!-- Pengaduan Details -->
                    <table style='width: 100%; border-collapse: collapse; margin: 20px 0; border: 1px solid #dee2e6;'>
                        <tr style='background-color: #f8f9fa;'>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; width: 30%; color: #495057;'>👤 Nama</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'>{$pengaduan->nama}</td>
                        </tr>
                        <tr>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>📧 Email</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6;'>
                                <a href='mailto:{$pengaduan->email}' style='color: #007bff; text-decoration: none;'>{$pengaduan->email}</a>
                            </td>
                        </tr>
                        <tr style='background-color: #f8f9fa;'>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>📱 No. HP</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'>" . ($pengaduan->telepon ?: '-') . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>📋 Kategori</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'><strong>{$pengaduan->kategori}</strong></td>
                        </tr>
                        <tr style='background-color: #f8f9fa;'>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>🕐 Waktu</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'>$waktu WIB</td>
                        </tr>
                    </table>

                    <!-- Message Content -->
                    <div style='margin: 25px 0;'>
                        <h3 style='color: #2E8B57; margin-bottom: 15px; font-size: 18px;'>💬 Isi Pengaduan:</h3>
                        <div style='background-color: #f8f9fa; border-left: 5px solid #2E8B57; padding: 20px; border-radius: 0 5px 5px 0; line-height: 1.6; white-space: pre-wrap;'>
                            {$pengaduan->pesan}
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='$adminUrl'
                           style='display: inline-block; background: linear-gradient(135deg, #2E8B57, #20B2AA); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; box-shadow: 0 4px 15px rgba(46,139,87,0.3); transition: all 0.3s;'>
                            🔍 Buka Admin Panel
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div style='background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #dee2e6;'>
                    <p style='margin: 0; color: #6c757d; font-size: 14px;'>
                        📧 Email otomatis dari <strong>Sistem PUPR Katingan</strong><br>
                        <small>Mohon tidak membalas email ini secara langsung</small>
                    </p>
                </div>

            </div>
        </body>
        </html>";
    }

    /**
     * Build text content for pengaduan email
     */
    private function buildPengaduanTextContent(Pengaduan $pengaduan)
    {
        $waktu = now()->format('d F Y, H:i');
        $adminUrl = url('/admin/pengaduan');

        return "
🚨 PENGADUAN BARU - PUPR KATINGAN
===============================

DETAIL PENGADUAN:
👤 Nama     : {$pengaduan->nama}
📧 Email    : {$pengaduan->email}
📱 No. HP   : " . ($pengaduan->telepon ?: '-') . "
📋 Kategori : {$pengaduan->kategori}
🕐 Waktu    : $waktu WIB

💬 ISI PENGADUAN:
{$pengaduan->pesan}

===============================
🔍 ADMIN PANEL: $adminUrl

Email otomatis dari Sistem PUPR Katingan
Jangan balas email ini secara langsung.
        ";
    }

    /**
     * Build HTML content for kontak email
     */
    private function buildKontakHtmlContent($kontakData)
    {
        $waktu = now()->format('d F Y, H:i');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Pesan Kontak Baru - PUPR Katingan</title>
        </head>
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;'>

                <!-- Header -->
                <div style='background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white; padding: 30px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 24px; font-weight: bold;'>💬 PESAN KONTAK BARU</h1>
                    <p style='margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;'>PUPR Katingan - Sistem Online</p>
                </div>

                <!-- Content -->
                <div style='padding: 30px;'>

                    <!-- Alert Box -->
                    <div style='background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; padding: 15px; margin-bottom: 25px;'>
                        <p style='margin: 0; color: #0c5460; font-weight: bold;'>
                            📬 Pesan baru dari masyarakat
                        </p>
                    </div>

                    <!-- Kontak Details -->
                    <table style='width: 100%; border-collapse: collapse; margin: 20px 0; border: 1px solid #dee2e6;'>
                        <tr style='background-color: #f8f9fa;'>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; width: 30%; color: #495057;'>👤 Nama</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'>{$kontakData['nama']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>📧 Email</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6;'>
                                <a href='mailto:{$kontakData['email']}' style='color: #007bff; text-decoration: none;'>{$kontakData['email']}</a>
                            </td>
                        </tr>
                        <tr style='background-color: #f8f9fa;'>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>📋 Subjek</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'><strong>{$kontakData['subjek']}</strong></td>
                        </tr>
                        <tr>
                            <td style='padding: 15px; border: 1px solid #dee2e6; font-weight: bold; color: #495057;'>🕐 Waktu</td>
                            <td style='padding: 15px; border: 1px solid #dee2e6; color: #212529;'>$waktu WIB</td>
                        </tr>
                    </table>

                    <!-- Message Content -->
                    <div style='margin: 25px 0;'>
                        <h3 style='color: #17a2b8; margin-bottom: 15px; font-size: 18px;'>📝 Isi Pesan:</h3>
                        <div style='background-color: #f8f9fa; border-left: 5px solid #17a2b8; padding: 20px; border-radius: 0 5px 5px 0; line-height: 1.6; white-space: pre-wrap;'>
                            {$kontakData['pesan']}
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='mailto:{$kontakData['email']}'
                           style='display: inline-block; background: linear-gradient(135deg, #17a2b8, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; box-shadow: 0 4px 15px rgba(23,162,184,0.3);'>
                            📧 Balas via Email
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div style='background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #dee2e6;'>
                    <p style='margin: 0; color: #6c757d; font-size: 14px;'>
                        💬 Email otomatis dari <strong>Sistem PUPR Katingan</strong><br>
                        <small>Balas langsung ke email pengirim untuk merespon</small>
                    </p>
                </div>

            </div>
        </body>
        </html>";
    }

    /**
     * Build text content for kontak email
     */
    private function buildKontakTextContent($kontakData)
    {
        $waktu = now()->format('d F Y, H:i');

        return "
💬 PESAN KONTAK BARU - PUPR KATINGAN
===================================

DETAIL PENGIRIM:
👤 Nama     : {$kontakData['nama']}
📧 Email    : {$kontakData['email']}
📋 Subjek   : {$kontakData['subjek']}
🕐 Waktu    : $waktu WIB

📝 ISI PESAN:
{$kontakData['pesan']}

===================================
📧 Untuk membalas: {$kontakData['email']}

Email otomatis dari Sistem PUPR Katingan
        ";
    }
}
