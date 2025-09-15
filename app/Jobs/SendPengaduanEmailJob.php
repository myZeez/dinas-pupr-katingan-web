<?php

namespace App\Jobs;

use App\Services\EmailNotificationService;
use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendPengaduanEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengaduan;

    /**
     * Create a new job instance.
     */
    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    /**
     * Execute the job.
     */
    public function handle(EmailNotificationService $emailService)
    {
        try {
            Log::info('SendPengaduanEmailJob: Starting email job', [
                'pengaduan_id' => $this->pengaduan->id
            ]);

            $result = $emailService->sendPengaduanNotification($this->pengaduan);

            Log::info('SendPengaduanEmailJob: Email job completed', [
                'pengaduan_id' => $this->pengaduan->id,
                'success' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('SendPengaduanEmailJob: Job failed', [
                'pengaduan_id' => $this->pengaduan->id,
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
        Log::error('SendPengaduanEmailJob: Job permanently failed', [
            'pengaduan_id' => $this->pengaduan->id,
            'error' => $exception->getMessage()
        ]);
    }
}
