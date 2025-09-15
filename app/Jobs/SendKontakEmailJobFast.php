<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendKontakEmailJobFast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kontakData;
    protected $adminEmails;

    public $tries = 2;
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(array $kontakData, array $adminEmails)
    {
        $this->kontakData = $kontakData;
        $this->adminEmails = $adminEmails;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $subject = "💬 Pesan Kontak Baru: {$this->kontakData['subjek']}";
            $content = $this->buildEmailContent();

            // Send bulk email with BCC for efficiency
            Mail::raw($content, function ($mail) use ($subject) {
                $mail->to($this->adminEmails[0])
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan');

                if (count($this->adminEmails) > 1) {
                    $mail->bcc(array_slice($this->adminEmails, 1));
                }
            });

            Log::info('SendKontakEmailJobFast: Email sent successfully', [
                'from_email' => $this->kontakData['email'],
                'subjek' => $this->kontakData['subjek'],
                'recipients' => count($this->adminEmails),
                'attempt' => $this->attempts()
            ]);
        } catch (\Exception $e) {
            Log::error('SendKontakEmailJobFast: Email sending failed', [
                'from_email' => $this->kontakData['email'],
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Don't re-throw if it's the final attempt, just log
            if ($this->attempts() >= $this->tries) {
                Log::info('SendKontakEmailJobFast: Final attempt failed, logging for manual processing', [
                    'from_email' => $this->kontakData['email'],
                    'nama' => $this->kontakData['nama'],
                    'subjek' => $this->kontakData['subjek']
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
        Log::error('SendKontakEmailJobFast: Job completely failed', [
            'from_email' => $this->kontakData['email'],
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
💬 PESAN KONTAK BARU - PUPR KATINGAN
=================================

📋 DETAIL PENGIRIM:
Nama    : {$this->kontakData['nama']}
Email   : {$this->kontakData['email']}
Subjek  : {$this->kontakData['subjek']}
Waktu   : {$waktu} WIB

📝 ISI PESAN:
{$this->kontakData['pesan']}

=================================
📧 Balas ke: {$this->kontakData['email']}

✉️  Dikirim via Queue Job - Sistem PUPR Katingan
⏰ Processed at: " . now()->format('Y-m-d H:i:s') . "
        ";
    }
}
