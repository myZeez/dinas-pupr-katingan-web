<?php

namespace App\Jobs;

use App\Services\EmailNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendKontakEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kontakData;

    /**
     * Create a new job instance.
     */
    public function __construct($kontakData)
    {
        $this->kontakData = $kontakData;
    }

    /**
     * Execute the job.
     */
    public function handle(EmailNotificationService $emailService)
    {
        try {
            Log::info('SendKontakEmailJob: Starting email job', [
                'from_email' => $this->kontakData['email']
            ]);

            $result = $emailService->sendKontakNotification($this->kontakData);

            Log::info('SendKontakEmailJob: Email job completed', [
                'from_email' => $this->kontakData['email'],
                'success' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('SendKontakEmailJob: Job failed', [
                'kontak_data' => $this->kontakData,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Re-throw exception to mark job as failed
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Exception $exception)
    {
        Log::error('SendKontakEmailJob: Job permanently failed', [
            'kontak_data' => $this->kontakData,
            'error' => $exception->getMessage()
        ]);
    }
}
