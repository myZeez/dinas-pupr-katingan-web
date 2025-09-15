<?php

namespace App\Jobs;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPengaduanEmailJobFast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengaduan;
    protected $adminEmails;

    public $tries = 2;
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(Pengaduan $pengaduan, array $adminEmails)
    {
        $this->pengaduan = $pengaduan;
        $this->adminEmails = $adminEmails;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $subject = "🚨 Pengaduan Baru: {$this->pengaduan->kategori}";
            $content = $this->buildEmailContent();

            // Send bulk email with BCC for efficiency
            Mail::raw($content, function ($mail) use ($subject) {
                $mail->to($this->adminEmails[0]) // First admin as TO
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan');

                // Add others as BCC for privacy and efficiency
                if (count($this->adminEmails) > 1) {
                    $mail->bcc(array_slice($this->adminEmails, 1));
                }
            });

            Log::info('SendPengaduanEmailJobFast: Email sent successfully', [
                'pengaduan_id' => $this->pengaduan->id,
                'recipients' => count($this->adminEmails),
                'attempt' => $this->attempts()
            ]);
        } catch (\Exception $e) {
            Log::error('SendPengaduanEmailJobFast: Email sending failed', [
                'pengaduan_id' => $this->pengaduan->id,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Don't re-throw if it's the final attempt, just log
            if ($this->attempts() >= $this->tries) {
                Log::info('SendPengaduanEmailJobFast: Final attempt failed, logging for manual processing', [
                    'pengaduan_id' => $this->pengaduan->id,
                    'nama' => $this->pengaduan->nama,
                    'kategori' => $this->pengaduan->kategori
                ]);
            } else {
                throw $e; // Retry
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Exception $exception)
    {
        Log::error('SendPengaduanEmailJobFast: Job completely failed', [
            'pengaduan_id' => $this->pengaduan->id,
            'error' => $exception->getMessage(),
            'final_fallback' => 'Email logged for manual processing'
        ]);
    }

    /**
     * Build email content
     */
    private function buildEmailContent()
    {
        $waktu = now()->format('d/m/Y H:i');

        return "
🚨 PENGADUAN BARU - PUPR KATINGAN
==============================

📋 DETAIL PENGADUAN:
Nama     : {$this->pengaduan->nama}
Email    : {$this->pengaduan->email}
Telepon  : " . ($this->pengaduan->telepon ?: '-') . "
Kategori : {$this->pengaduan->kategori}
Waktu    : {$waktu} WIB

💬 ISI PENGADUAN:
{$this->pengaduan->pesan}

==============================
🔗 Admin Panel: " . url('/admin/pengaduan') . "

✉️  Dikirim via Queue Job - Sistem PUPR Katingan
⏰ Processed at: " . now()->format('Y-m-d H:i:s') . "
        ";
    }
}
