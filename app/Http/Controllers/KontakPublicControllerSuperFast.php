<?php

namespace App\Http\Controllers;

use App\Services\SuperFastEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakPublicControllerSuperFast extends Controller
{
    protected $superFastEmailService;

    public function __construct(SuperFastEmailNotificationService $superFastEmailService)
    {
        $this->superFastEmailService = $superFastEmailService;
    }

    /**
     * Handle kontak form submission with SUPER FAST processing
     * No email sending - only logging for later processing
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
            // Prepare data for processing
            $kontakData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
                'waktu' => now()->format('d/m/Y H:i:s')
            ];

            // Log email data for later processing (SUPER FAST)
            $logged = $this->superFastEmailService->sendKontakNotificationSuperFast($kontakData);

            Log::info('KontakPublicSuperFast: Kontak processed super fast', [
                'from_email' => $request->email,
                'subjek' => $request->subjek,
                'logged_for_email' => $logged ? 'YES' : 'NO'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda telah berhasil dikirim. Kami akan segera merespons.',
                'data' => [
                    'status' => 'Terkirim',
                    'processing' => 'Super Fast',
                    'email_notification' => $logged ? 'Diproses Otomatis' : 'Dicatat'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('KontakPublicSuperFast: Failed to process kontak', [
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
