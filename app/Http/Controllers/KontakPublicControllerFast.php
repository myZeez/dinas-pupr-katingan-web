<?php

namespace App\Http\Controllers;

use App\Services\FastEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakPublicControllerFast extends Controller
{
    protected $fastEmailService;

    public function __construct(FastEmailNotificationService $fastEmailService)
    {
        $this->fastEmailService = $fastEmailService;
    }

    /**
     * Handle kontak form submission with FAST email notification
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

            // Send FAST email notification (optimized for speed)
            $emailSent = $this->fastEmailService->sendKontakNotificationFast($kontakData);

            Log::info('KontakPublic: Kontak processed successfully', [
                'from_email' => $request->email,
                'subjek' => $request->subjek,
                'email_sent' => $emailSent ? 'YES' : 'LOGGED_FALLBACK'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda telah berhasil dikirim. Kami akan segera merespons.',
                'data' => [
                    'status' => 'Terkirim',
                    'email_notification' => $emailSent ? 'Terkirim ke Admin' : 'Akan diproses'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('KontakPublic: Failed to process kontak', [
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
