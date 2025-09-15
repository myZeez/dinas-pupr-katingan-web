<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pengaduan;
use App\Jobs\SendPengaduanEmailJobFast;
use App\Jobs\SendKontakEmailJobFast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class InstantEmailNotificationService
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
     * Send pengaduan notification INSTANTLY (queue job)
     */
    public function sendPengaduanNotificationInstant(Pengaduan $pengaduan)
    {
        try {
            // Get cached admin emails for speed
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('InstantEmailService: No admin emails found', [
                    'pengaduan_id' => $pengaduan->id
                ]);
                return false;
            }

            // Dispatch job to queue (INSTANT return)
            SendPengaduanEmailJobFast::dispatch($pengaduan, $adminEmails);

            Log::info('InstantEmailService: Job dispatched for pengaduan', [
                'pengaduan_id' => $pengaduan->id,
                'recipients' => count($adminEmails),
                'status' => 'QUEUED'
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('InstantEmailService: Failed to dispatch pengaduan job', [
                'pengaduan_id' => $pengaduan->id,
                'error' => $e->getMessage()
            ]);

            // Fallback to log only (super fast)
            $this->logEmailFallback('pengaduan', $pengaduan);
            return false;
        }
    }

    /**
     * Send kontak notification INSTANTLY (queue job)
     */
    public function sendKontakNotificationInstant($kontakData)
    {
        try {
            // Get cached admin emails
            $adminEmails = $this->getCachedAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('InstantEmailService: No admin emails for kontak');
                return false;
            }

            // Dispatch job to queue (INSTANT return)
            SendKontakEmailJobFast::dispatch($kontakData, $adminEmails);

            Log::info('InstantEmailService: Job dispatched for kontak', [
                'from_email' => $kontakData['email'],
                'recipients' => count($adminEmails),
                'status' => 'QUEUED'
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('InstantEmailService: Failed to dispatch kontak job', [
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
        return Cache::remember('instant_admin_emails', 300, function () {
            return User::whereIn('role', ['super_admin', 'admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->toArray();
        });
    }

    /**
     * Log email fallback (super fast)
     */
    private function logEmailFallback($type, $pengaduan)
    {
        Log::info("InstantEmailService: Email logged as fallback", [
            'type' => $type,
            'pengaduan_id' => $pengaduan->id,
            'nama' => $pengaduan->nama,
            'kategori' => $pengaduan->kategori,
            'fallback_reason' => 'Job dispatch failed, logged for manual processing'
        ]);
    }

    /**
     * Log kontak fallback
     */
    private function logKontakFallback($kontakData)
    {
        Log::info("InstantEmailService: Kontak logged as fallback", [
            'type' => 'kontak',
            'nama' => $kontakData['nama'],
            'email' => $kontakData['email'],
            'subjek' => $kontakData['subjek'],
            'fallback_reason' => 'Job dispatch failed, logged for manual processing'
        ]);
    }

    /**
     * Check queue health and stats
     */
    public function getQueueStats()
    {
        try {
            // Get basic queue info (if available)
            return [
                'status' => 'active',
                'service' => 'InstantEmailNotificationService',
                'cache_ttl' => 300,
                'jobs_available' => class_exists('App\Jobs\SendPengaduanEmailJob'),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];
        }
    }
}
