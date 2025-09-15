<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\InstantEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengaduanPublicControllerInstant extends Controller
{
    protected $instantEmailService;

    public function __construct(InstantEmailNotificationService $instantEmailService)
    {
        $this->instantEmailService = $instantEmailService;
    }

    /**
     * Handle pengaduan form submission with INSTANT email notification (queue)
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
                'kategori' => $request->kategori,
                'pesan' => $request->pesan,
                'status' => 'Baru',
                'created_at' => now(),
            ]);

            // Send INSTANT email notification via queue (returns immediately)
            $jobDispatched = $this->instantEmailService->sendPengaduanNotificationInstant($pengaduan);

            DB::commit();

            Log::info('PengaduanPublicInstant: Pengaduan created successfully', [
                'pengaduan_id' => $pengaduan->id,
                'job_dispatched' => $jobDispatched ? 'YES' : 'FALLBACK'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan Anda telah berhasil dikirim dan akan segera ditindaklanjuti.',
                'data' => [
                    'id' => $pengaduan->id,
                    'status' => 'Terkirim',
                    'email_notification' => $jobDispatched ? 'Diproses di Background' : 'Dicatat di Log'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('PengaduanPublicInstant: Failed to create pengaduan', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show form for creating new pengaduan
     */
    public function create()
    {
        return view('public.pengaduan.create');
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('public.pengaduan.success');
    }
}
