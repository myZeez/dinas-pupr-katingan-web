<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\SuperFastEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengaduanPublicControllerSuperFast extends Controller
{
    protected $superFastEmailService;

    public function __construct(SuperFastEmailNotificationService $superFastEmailService)
    {
        $this->superFastEmailService = $superFastEmailService;
    }

    /**
     * Handle pengaduan form submission with SUPER FAST processing
     * No email sending - only logging for later processing
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

            // Log email data for later processing (SUPER FAST)
            $logged = $this->superFastEmailService->sendPengaduanNotificationSuperFast($pengaduan);

            DB::commit();

            Log::info('PengaduanPublicSuperFast: Pengaduan created super fast', [
                'pengaduan_id' => $pengaduan->id,
                'logged_for_email' => $logged ? 'YES' : 'NO'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan Anda telah berhasil dikirim dan akan segera ditindaklanjuti.',
                'data' => [
                    'id' => $pengaduan->id,
                    'status' => 'Terkirim',
                    'processing' => 'Super Fast',
                    'email_notification' => $logged ? 'Diproses Otomatis' : 'Dicatat'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('PengaduanPublicSuperFast: Failed to create pengaduan', [
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
