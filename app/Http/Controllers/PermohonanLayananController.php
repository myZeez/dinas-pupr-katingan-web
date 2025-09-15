<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanLayanan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermohonanLayananController extends Controller
{
    /**
     * STRUKTUR BARU - Form Handler yang Efisien
     * Disesuaikan dengan field form yang ada di resources/views/public/layanan.blade.php
     */
    public function store(Request $request)
    {
        // Log incoming request untuk debugging
        Log::info('🔥 NEW EFFICIENT PERMOHONAN SUBMISSION', [
            'timestamp' => now()->toISOString(),
            'ip' => $request->ip(),
            'all_data' => $request->all(),
            'files' => $request->hasFile('documents') ? 'YES' : 'NO'
        ]);

        try {
            // Validasi yang sesuai dengan form field names
            $validated = $request->validate([
                // Data Pemohon (sesuai form di layanan.blade.php)
                'nama' => 'required|string|min:2|max:255',
                'nik' => 'required|digits:16',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|min:10|max:15',
                'alamat' => 'required|string|min:10|max:500',

                // Jenis Layanan (sesuai options di form)
                'jenis_layanan' => 'required|in:permohonan_imb,permohonan_sbg,permohonan_rtbl,permohonan_advice_planning,permohonan_pkkpr',

                // Deskripsi
                'deskripsi' => 'required|string|min:20|max:2000',

                // File uploads (optional)
                'documents' => 'nullable|array|max:5',
                'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120' // 5MB
            ], [
                // Custom error messages
                'nama.required' => 'Nama lengkap wajib diisi',
                'nik.required' => 'NIK wajib diisi',
                'nik.digits' => 'NIK harus 16 digit',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'telepon.required' => 'Nomor telepon wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
                'jenis_layanan.required' => 'Jenis layanan wajib dipilih',
                'jenis_layanan.in' => 'Jenis layanan tidak valid',
                'deskripsi.required' => 'Deskripsi permohonan wajib diisi',
                'deskripsi.min' => 'Deskripsi minimal 20 karakter',
                'documents.*.mimes' => 'File harus berformat PDF, DOC, DOCX, JPG, atau PNG',
                'documents.*.max' => 'Ukuran file maksimal 5MB'
            ]);

            Log::info('✅ VALIDATION PASSED', $validated);

            // Generate nomor permohonan dengan format baru
            $nomorPermohonan = $this->generateNomorPermohonan();

            // Handle file uploads dengan metode baru
            $uploadedFiles = $this->handleFileUploads($request);

            // Transform jenis layanan ke format yang lebih readable
            $jenisLayananMap = [
                'permohonan_imb' => 'Izin Mendirikan Bangunan (IMB)',
                'permohonan_sbg' => 'Surat Bukti Gangguan (SBG)',
                'permohonan_rtbl' => 'Rencana Tata Bangunan dan Lingkungan (RTBL)',
                'permohonan_advice_planning' => 'Advice Planning',
                'permohonan_pkkpr' => 'Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)'
            ];

            // Simpan ke database dengan struktur baru
            $permohonan = PermohonanLayanan::create([
                'nomor_permohonan' => $nomorPermohonan,
                'jenis_layanan' => $jenisLayananMap[$validated['jenis_layanan']] ?? $validated['jenis_layanan'],
                'jenis_layanan_code' => $validated['jenis_layanan'], // Simpan juga code asli
                'nama_pemohon' => trim($validated['nama']),
                'nik' => $validated['nik'],
                'email' => strtolower(trim($validated['email'])),
                'telepon' => preg_replace('/[^\d+]/', '', $validated['telepon']),
                'alamat' => trim($validated['alamat']),
                'deskripsi' => trim($validated['deskripsi']),
                'keperluan' => trim($validated['deskripsi']), // Backward compatibility
                'dokumen_persyaratan' => $uploadedFiles,
                'status' => 'Diajukan',
                'tanggal_permohonan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('🎉 PERMOHONAN CREATED SUCCESSFULLY', [
                'id' => $permohonan->id,
                'nomor' => $nomorPermohonan,
                'nama' => $permohonan->nama_pemohon,
                'jenis' => $permohonan->jenis_layanan,
                'files_count' => count($uploadedFiles)
            ]);

            // Response yang lebih informatif
            $response = [
                'success' => true,
                'message' => '🎉 Permohonan berhasil diajukan!',
                'data' => [
                    'nomor_permohonan' => $nomorPermohonan,
                    'status' => 'Diajukan',
                    'jenis_layanan' => $permohonan->jenis_layanan,
                    'tanggal_permohonan' => $permohonan->tanggal_permohonan->format('d/m/Y H:i'),
                    'files_uploaded' => count($uploadedFiles),
                    'tracking_url' => route('public.permohonan.track'),
                    'estimasi_proses' => '5-14 hari kerja'
                ]
            ];

            if ($request->expectsJson()) {
                return response()->json($response, 201);
            }

            return redirect()->back()
                ->with('success', $response['message'])
                ->with('permohonan_data', $response['data']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('❌ VALIDATION FAILED', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token', 'documents'])
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data yang dimasukkan tidak valid',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang Anda masukkan');
        } catch (\Exception $e) {
            Log::error('💥 SYSTEM ERROR', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Generate nomor permohonan dengan format yang lebih baik
     */
    private function generateNomorPermohonan(): string
    {
        $date = now();
        $prefix = 'REQ';
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Hitung nomor urut hari ini
        $todayCount = PermohonanLayanan::whereDate('created_at', $date->toDateString())->count() + 1;
        $sequence = str_pad($todayCount, 4, '0', STR_PAD_LEFT);

        return "{$prefix}-{$year}{$month}{$day}-{$sequence}";
    }

    /**
     * Handle file uploads dengan struktur yang lebih baik
     */
    private function handleFileUploads(Request $request): array
    {
        $uploadedFiles = [];

        if (!$request->hasFile('documents')) {
            return $uploadedFiles;
        }

        $files = $request->file('documents');
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            try {
                // Generate secure filename
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $secureFilename = Str::random(8) . '_' . time() . '.' . $extension;

                // Store in organized folder structure
                $folder = 'permohonan-layanan/' . now()->format('Y/m');
                $path = $file->storeAs($folder, $secureFilename, 'public');

                $uploadedFiles[] = [
                    'index' => $index + 1,
                    'original_name' => $originalName,
                    'stored_name' => $secureFilename,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString(),
                    'url' => Storage::url($path)
                ];

                Log::info("📁 File uploaded: {$originalName} -> {$secureFilename}");
            } catch (\Exception $e) {
                Log::error("❌ File upload failed: {$file->getClientOriginalName()}", [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $uploadedFiles;
    }

    /**
     * Track permohonan dengan cara yang lebih efisien
     */
    public function track(Request $request)
    {
        $request->validate([
            'nomor_permohonan' => 'required|string|regex:/^REQ-\d{8}-\d{4}$/'
        ], [
            'nomor_permohonan.required' => 'Nomor permohonan wajib diisi',
            'nomor_permohonan.regex' => 'Format nomor permohonan tidak valid'
        ]);

        $permohonan = PermohonanLayanan::where('nomor_permohonan', $request->nomor_permohonan)->first();

        if (!$permohonan) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor permohonan tidak ditemukan'
                ], 404);
            }

            return redirect()->back()->with('error', 'Nomor permohonan tidak ditemukan');
        }

        $trackingData = [
            'nomor_permohonan' => $permohonan->nomor_permohonan,
            'status' => $permohonan->status,
            'jenis_layanan' => $permohonan->jenis_layanan,
            'nama_pemohon' => $permohonan->nama_pemohon,
            'tanggal_permohonan' => $permohonan->tanggal_permohonan->format('d/m/Y H:i'),
            'files_count' => is_array($permohonan->dokumen_persyaratan) ? count($permohonan->dokumen_persyaratan) : 0,
            'has_result' => !empty($permohonan->file_hasil),
            'catatan_admin' => $permohonan->catatan_admin
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $trackingData
            ]);
        }

        return view('public.track-permohonan', compact('permohonan', 'trackingData'));
    }

    /**
     * Download hasil permohonan
     */
    public function downloadResult($nomorPermohonan)
    {
        $permohonan = PermohonanLayanan::where('nomor_permohonan', $nomorPermohonan)
            ->where('status', 'Selesai')
            ->first();

        if (!$permohonan || !$permohonan->file_hasil) {
            abort(404, 'File hasil tidak ditemukan atau permohonan belum selesai');
        }

        $filePath = storage_path('app/public/' . $permohonan->file_hasil);

        if (!file_exists($filePath)) {
            Log::error('Result file not found', [
                'nomor_permohonan' => $nomorPermohonan,
                'expected_path' => $filePath
            ]);
            abort(404, 'File tidak ditemukan di server');
        }

        Log::info('Result file downloaded', [
            'nomor_permohonan' => $nomorPermohonan,
            'ip' => request()->ip()
        ]);

        return response()->download($filePath, "Hasil_Permohonan_{$nomorPermohonan}.pdf");
    }

    /**
     * Get jenis layanan untuk API
     */
    public function getJenisLayanan()
    {
        $jenisLayanan = [
            'permohonan_imb' => 'Izin Mendirikan Bangunan (IMB)',
            'permohonan_sbg' => 'Surat Bukti Gangguan (SBG)',
            'permohonan_rtbl' => 'Rencana Tata Bangunan dan Lingkungan (RTBL)',
            'permohonan_advice_planning' => 'Advice Planning',
            'permohonan_pkkpr' => 'Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)'
        ];

        return response()->json([
            'success' => true,
            'data' => $jenisLayanan
        ]);
    }
}
