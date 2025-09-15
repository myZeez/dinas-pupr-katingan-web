<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\FastEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\EmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengaduanPublicController extends Controller
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle pengaduan form submission with email notification
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'kategori' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Create pengaduan record
            $pengaduan = Pengaduan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'subjek' => $request->kategori,  // FIXED: Map kategori to subjek column
                'pesan' => $request->pesan,
                'status' => 'Baru',
            ]);

            Log::info('PengaduanPublicController: New pengaduan created', [
                'pengaduan_id' => $pengaduan->id,
                'nama' => $pengaduan->nama,
                'email' => $pengaduan->email,
                'kategori' => $pengaduan->kategori
            ]);

            DB::commit();

            // Send email notification (non-blocking)
            try {
                $emailSent = $this->emailService->sendPengaduanNotification($pengaduan);

                Log::info('PengaduanPublicController: Email notification result', [
                    'pengaduan_id' => $pengaduan->id,
                    'email_sent' => $emailSent
                ]);
            } catch (\Exception $emailError) {
                // Email failure shouldn't block the pengaduan creation
                Log::warning('PengaduanPublicController: Email notification failed but pengaduan saved', [
                    'pengaduan_id' => $pengaduan->id,
                    'email_error' => $emailError->getMessage()
                ]);
            }

            return redirect()->back()->with('success', 'Pengaduan Anda berhasil dikirim. Terima kasih!');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('PengaduanPublicController: Failed to create pengaduan', [
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
