<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class FastEmailNotificationService
{
    /**
     * Constructor - Force correct email configuration
     */
    public function __construct()
    {
        // Force override konfigurasi email untuk memastikan menggunakan nilai yang benar
        config([
            'mail.mailers.smtp.username' => env('MAIL_USERNAME', 'budiaat25@gmail.com'),
            'mail.mailers.smtp.password' => env('MAIL_PASSWORD', 'wucrxukoatvwpnei'),
            'mail.from.address' => env('MAIL_FROM_ADDRESS', 'budiaat25@gmail.com'),
            'mail.from.name' => env('MAIL_FROM_NAME', 'DINAS PUPR KATINGAN'),
            'mail.default' => env('MAIL_MAILER', 'smtp')
        ]);
    }

    /**
     * Send pengaduan notification quickly (optimized)
     */
    public function sendPengaduanNotificationFast(Pengaduan $pengaduan)
    {
        try {
            // Get cached admin emails for speed
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('FastEmailService: No admin emails found', [
                    'pengaduan_id' => $pengaduan->id
                ]);
                return false;
            }

            // Send to multiple recipients in single email (fastest)
            $this->sendBulkEmail($adminEmails, $pengaduan);

            Log::info('FastEmailService: Bulk email sent', [
                'pengaduan_id' => $pengaduan->id,
                'recipients' => count($adminEmails)
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('FastEmailService: Fast notification failed', [
                'pengaduan_id' => $pengaduan->id,
                'error' => $e->getMessage()
            ]);

            // Fallback to log only (super fast)
            $this->logEmailFallback('pengaduan', $pengaduan);
            return false;
        }
    }

    /**
     * Send kontak notification quickly
     */
    public function sendKontakNotificationFast($kontakData)
    {
        try {
            // Get cached admin emails
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('FastEmailService: No admin emails for kontak');
                return false;
            }

            // Send to multiple recipients in single email
            $this->sendBulkKontakEmail($adminEmails, $kontakData);

            Log::info('FastEmailService: Bulk kontak email sent', [
                'from_email' => $kontakData['email'],
                'recipients' => count($adminEmails)
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('FastEmailService: Fast kontak notification failed', [
                'from_email' => $kontakData['email'],
                'error' => $e->getMessage()
            ]);

            // Fallback to log only
            $this->logKontakFallback($kontakData);
            return false;
        }
    }

    /**
     * Get admin emails with caching (5 minutes)
     */
    private function getCachedAdminEmails()
    {
        return Cache::remember('admin_emails', 300, function () {
            return User::whereIn('role', ['super_admin', 'admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->toArray();
        });
    }

    /**
     * Send bulk email for pengaduan (single email, multiple BCC)
     */
    private function sendBulkEmail($adminEmails, $pengaduan)
    {
        $subject = "🚨 Pengaduan Baru: {$pengaduan->kategori}";
        $content = $this->getSimplePengaduanContent($pengaduan);

        try {
            // Try SMTP with BCC (fastest for multiple recipients)
            Mail::raw($content, function ($mail) use ($adminEmails, $subject) {
                $mail->to($adminEmails[0]) // First admin as TO
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan');

                // Add others as BCC for privacy
                if (count($adminEmails) > 1) {
                    $mail->bcc(array_slice($adminEmails, 1));
                }
            });
        } catch (\Exception $e) {
            // Fallback: Log the email content
            throw $e;
        }
    }

    /**
     * Send bulk email for kontak
     */
    private function sendBulkKontakEmail($adminEmails, $kontakData)
    {
        $subject = "💬 Pesan Kontak Baru: {$kontakData['subjek']}";
        $content = $this->getSimpleKontakContent($kontakData);

        try {
            Mail::raw($content, function ($mail) use ($adminEmails, $subject) {
                $mail->to($adminEmails[0])
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan');

                if (count($adminEmails) > 1) {
                    $mail->bcc(array_slice($adminEmails, 1));
                }
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get simple pengaduan content (optimized for speed)
     */
    private function getSimplePengaduanContent($pengaduan)
    {
        $waktu = now()->format('d/m/Y H:i');

        return "
🚨 PENGADUAN BARU - PUPR KATINGAN
==============================

📋 DETAIL PENGADUAN:
Nama     : {$pengaduan->nama}
Email    : {$pengaduan->email}
Telepon  : " . ($pengaduan->telepon ?: '-') . "
Kategori : {$pengaduan->kategori}
Waktu    : {$waktu} WIB

💬 ISI PENGADUAN:
{$pengaduan->pesan}

==============================
🔗 Admin Panel: " . url('/admin/pengaduan') . "

Email otomatis dari Sistem PUPR Katingan
        ";
    }

    /**
     * Get simple kontak content
     */
    private function getSimpleKontakContent($kontakData)
    {
        $waktu = now()->format('d/m/Y H:i');

        return "
💬 PESAN KONTAK BARU - PUPR KATINGAN
=================================

📋 DETAIL PENGIRIM:
Nama    : {$kontakData['nama']}
Email   : {$kontakData['email']}
Subjek  : {$kontakData['subjek']}
Waktu   : {$waktu} WIB

📝 ISI PESAN:
{$kontakData['pesan']}

=================================
📧 Balas ke: {$kontakData['email']}

Email otomatis dari Sistem PUPR Katingan
        ";
    }

    /**
     * Log email fallback (super fast)
     */
    private function logEmailFallback($type, $pengaduan)
    {
        Log::info("FastEmailService: Email logged as fallback", [
            'type' => $type,
            'pengaduan_id' => $pengaduan->id,
            'nama' => $pengaduan->nama,
            'kategori' => $pengaduan->kategori,
            'fallback_reason' => 'SMTP failed, logged for manual processing'
        ]);
    }

    /**
     * Log kontak fallback
     */
    private function logKontakFallback($kontakData)
    {
        Log::info("FastEmailService: Kontak logged as fallback", [
            'type' => 'kontak',
            'nama' => $kontakData['nama'],
            'email' => $kontakData['email'],
            'subjek' => $kontakData['subjek'],
            'fallback_reason' => 'SMTP failed, logged for manual processing'
        ]);
    }
}
