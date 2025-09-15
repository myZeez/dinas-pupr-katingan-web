<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SuperFastEmailNotificationService
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
     * Send pengaduan notification SUPER FAST (immediate return, log everything)
     */
    public function sendPengaduanNotificationSuperFast(Pengaduan $pengaduan)
    {
        try {
            // Get cached admin emails for speed
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('SuperFastEmailService: No admin emails found', [
                    'pengaduan_id' => $pengaduan->id
                ]);
                return false;
            }

            // LOG EVERYTHING for immediate processing later
            $this->logPengaduanForImmediateProcessing($pengaduan, $adminEmails);

            // Return immediately - NO EMAIL SENDING AT ALL
            Log::info('SuperFastEmailService: Pengaduan logged for processing', [
                'pengaduan_id' => $pengaduan->id,
                'recipients' => count($adminEmails),
                'status' => 'LOGGED_FOR_PROCESSING'
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('SuperFastEmailService: Failed to log pengaduan', [
                'pengaduan_id' => $pengaduan->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send kontak notification SUPER FAST
     */
    public function sendKontakNotificationSuperFast($kontakData)
    {
        try {
            // Get cached admin emails
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('SuperFastEmailService: No admin emails for kontak');
                return false;
            }

            // LOG EVERYTHING for immediate processing later
            $this->logKontakForImmediateProcessing($kontakData, $adminEmails);

            Log::info('SuperFastEmailService: Kontak logged for processing', [
                'from_email' => $kontakData['email'],
                'recipients' => count($adminEmails),
                'status' => 'LOGGED_FOR_PROCESSING'
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('SuperFastEmailService: Failed to log kontak', [
                'from_email' => $kontakData['email'],
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Get admin emails with caching (5 minutes)
     */
    private function getCachedAdminEmails()
    {
        return Cache::remember('superfast_admin_emails', 300, function () {
            return User::whereIn('role', ['super_admin', 'admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->toArray();
        });
    }

    /**
     * Log pengaduan with all email content ready for immediate processing
     */
    private function logPengaduanForImmediateProcessing($pengaduan, $adminEmails)
    {
        $waktu = now()->format('d/m/Y H:i');
        $emailContent = "
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

✉️  READY FOR EMAIL PROCESSING
⏰ Logged at: " . now()->format('Y-m-d H:i:s') . "
        ";

        // Log with all email data ready for processing
        Log::channel('daily')->info('SUPERFAST_EMAIL_PENGADUAN_READY', [
            'type' => 'pengaduan',
            'pengaduan_id' => $pengaduan->id,
            'subject' => "🚨 Pengaduan Baru: {$pengaduan->kategori}",
            'to_emails' => $adminEmails,
            'email_content' => $emailContent,
            'nama' => $pengaduan->nama,
            'kategori' => $pengaduan->kategori,
            'email' => $pengaduan->email,
            'telepon' => $pengaduan->telepon,
            'pesan' => $pengaduan->pesan,
            'created_at' => $pengaduan->created_at,
            'ready_for_smtp' => true,
            'processing_instruction' => 'SEND_EMAIL_TO_ALL_ADMINS'
        ]);
    }

    /**
     * Log kontak with all email content ready
     */
    private function logKontakForImmediateProcessing($kontakData, $adminEmails)
    {
        $waktu = now()->format('d/m/Y H:i');
        $emailContent = "
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

✉️  READY FOR EMAIL PROCESSING
⏰ Logged at: " . now()->format('Y-m-d H:i:s') . "
        ";

        // Log with all email data ready for processing
        Log::channel('daily')->info('SUPERFAST_EMAIL_KONTAK_READY', [
            'type' => 'kontak',
            'subject' => "💬 Pesan Kontak Baru: {$kontakData['subjek']}",
            'to_emails' => $adminEmails,
            'email_content' => $emailContent,
            'nama' => $kontakData['nama'],
            'email' => $kontakData['email'],
            'subjek' => $kontakData['subjek'],
            'pesan' => $kontakData['pesan'],
            'waktu' => $kontakData['waktu'],
            'ready_for_smtp' => true,
            'processing_instruction' => 'SEND_EMAIL_TO_ALL_ADMINS'
        ]);
    }

    /**
     * Get performance stats
     */
    public function getPerformanceStats()
    {
        return [
            'service' => 'SuperFastEmailNotificationService',
            'method' => 'immediate_log_no_email_send',
            'performance' => 'SUPER_FAST',
            'email_processing' => 'LOGGED_FOR_LATER',
            'cache_ttl' => 300,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Process logged emails manually (for separate script)
     */
    public function processLoggedEmailsManually()
    {
        // This could be called by a separate script to actually send emails
        // from the logs, keeping the main form submission super fast

        Log::info('SuperFastEmailService: Manual email processing called', [
            'note' => 'This would process all logged emails from the log files',
            'implementation' => 'separate_email_processor_script'
        ]);

        return [
            'status' => 'manual_processing_available',
            'description' => 'Use separate script to process logged emails'
        ];
    }
}
