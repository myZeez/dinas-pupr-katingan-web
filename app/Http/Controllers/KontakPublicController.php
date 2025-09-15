<?php

namespace App\Http\Controllers;

use App\Services\EmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakPublicController extends Controller
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle kontak form submission with email notification
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
            $kontakData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
            ];

            Log::info('KontakPublicController: New kontak message', [
                'nama' => $kontakData['nama'],
                'email' => $kontakData['email'],
                'subjek' => $kontakData['subjek']
            ]);

            // Send email notification
            try {
                $emailSent = $this->emailService->sendKontakNotification($kontakData);

                Log::info('KontakPublicController: Email notification result', [
                    'from_email' => $kontakData['email'],
                    'email_sent' => $emailSent
                ]);
            } catch (\Exception $emailError) {
                // Email failure shouldn't block the form submission
                Log::warning('KontakPublicController: Email notification failed', [
                    'from_email' => $kontakData['email'],
                    'email_error' => $emailError->getMessage()
                ]);
            }

            return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
        } catch (\Exception $e) {
            Log::error('KontakPublicController: Failed to process kontak', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->except(['_token'])
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
