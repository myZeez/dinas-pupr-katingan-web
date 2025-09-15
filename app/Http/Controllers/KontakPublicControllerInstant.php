<?php

namespace App\Http\Controllers;

use App\Services\InstantEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakPublicControllerInstant extends Controller
{
    protected $instantEmailService;

    public function __construct(InstantEmailNotificationService $instantEmailService)
    {
        $this->instantEmailService = $instantEmailService;
    }

    /**
     * Handle kontak form submission with INSTANT email notification (queue)
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        try {
            // Prepare data for email
            $kontakData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
                'waktu' => now()->format('d/m/Y H:i:s')
            ];

            // Send INSTANT email notification via queue (returns immediately)
            $jobDispatched = $this->instantEmailService->sendKontakNotificationInstant($kontakData);

            Log::info('KontakPublicInstant: Kontak processed successfully', [
                'from_email' => $request->email,
                'subjek' => $request->subjek,
                'job_dispatched' => $jobDispatched ? 'YES' : 'FALLBACK'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda telah berhasil dikirim. Kami akan segera merespons.',
                'data' => [
                    'status' => 'Terkirim',
                    'email_notification' => $jobDispatched ? 'Diproses di Background' : 'Dicatat di Log'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('KontakPublicInstant: Failed to process kontak', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show kontak form
     */
    public function create()
    {
        return view('public.kontak.create');
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('public.kontak.success');
    }
}
