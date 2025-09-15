<?php

namespace App\Services;

use App\Models\PermohonanLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PermohonanLayananService
{
    /**
     * Daftar jenis layanan yang tersedia
     */
    public const JENIS_LAYANAN = [
        'permohonan_imb' => 'Permohonan Izin Mendirikan Bangunan (IMB)',
        'permohonan_sbg' => 'Permohonan Surat Bukti Gangguan (SBG)',
        'permohonan_rtbl' => 'Permohonan Rencana Tata Bangunan dan Lingkungan (RTBL)',
        'permohonan_advice_planning' => 'Permohonan Advice Planning',
        'permohonan_pkkpr' => 'Permohonan Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)',
        'Surat Permohonan' => 'Pengajuan surat permohonan resmi',
        'Peta Lokasi' => 'Permintaan peta lokasi dan denah',
        'Data Teknis Bangunan/Kawasan' => 'Data teknis untuk bangunan atau kawasan',
        'Dokumen Pendukung' => 'Dokumen pendukung lainnya'
    ];

    /**
     * Status permohonan yang tersedia
     */
    public const STATUS_PERMOHONAN = [
        'Diajukan' => 'badge-primary',
        'Verifikasi' => 'badge-warning',
        'Diproses' => 'badge-info',
        'Selesai' => 'badge-success',
        'Ditolak' => 'badge-danger'
    ];

    /**
     * Konstanta untuk file upload
     */
    public const ALLOWED_FILE_TYPES = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    public const MAX_FILE_SIZE = 2048; // KB
    public const MAX_FILES = 5;

    /**
     * Generate nomor permohonan unik dengan format yang konsisten
     */
    public function generateNomorPermohonan(): string
    {
        $today = now();
        $prefix = 'REQ';
        $dateFormat = $today->format('Ymd');

        // Hitung jumlah permohonan hari ini
        $todayCount = PermohonanLayanan::whereDate('created_at', $today->toDateString())->count();
        $sequence = str_pad($todayCount + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}-{$dateFormat}-{$sequence}";
    }

    /**
     * Validasi dan upload file dengan keamanan yang ketat
     */
    public function handleFileUpload(): array
    {
        $uploadedFiles = [];

        if (!request()->hasFile('documents')) {
            return $uploadedFiles;
        }

        $files = request()->file('documents');

        // Pastikan files adalah array
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) {
                Log::warning('Invalid file detected', ['index' => $index]);
                continue;
            }

            try {
                $uploadedFile = $this->processFile($file);
                if ($uploadedFile) {
                    $uploadedFiles[] = $uploadedFile;
                }
            } catch (\Exception $e) {
                Log::error('File upload error', [
                    'file_index' => $index,
                    'original_name' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $uploadedFiles;
    }

    /**
     * Process individual file upload
     */
    private function processFile($file): ?array
    {
        // Validasi tambahan untuk keamanan
        $allowedMimes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $maxSize = 2048 * 1024; // 2MB in bytes

        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedMimes)) {
            throw new \Exception('File type not allowed: ' . $file->getClientOriginalExtension());
        }

        if ($file->getSize() > $maxSize) {
            throw new \Exception('File size exceeds 2MB limit');
        }

        // Generate secure filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $secureFilename = $this->generateSecureFilename($extension);

        // Store file di folder yang terorganisir berdasarkan tanggal
        $folder = 'permohonan-layanan/' . now()->format('Y/m');
        $path = $file->storeAs($folder, $secureFilename, 'public');

        if (!$path) {
            throw new \Exception('Failed to store file');
        }

        return [
            'original_name' => $originalName,
            'stored_name' => $secureFilename,
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'upload_date' => now()->toISOString(),
            'folder' => $folder
        ];
    }

    /**
     * Generate secure filename untuk mencegah path traversal
     */
    private function generateSecureFilename(string $extension): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            now()->format('YmdHis'),
            Str::random(8),
            uniqid(),
            $extension
        );
    }

    /**
     * Validasi duplikasi berdasarkan NIK
     */
    public function checkDuplication(string $nik): ?PermohonanLayanan
    {
        return PermohonanLayanan::where('nik', $nik)
            ->where('created_at', '>', now()->subHours(24))
            ->whereIn('status', ['Diajukan', 'Verifikasi', 'Diproses'])
            ->first();
    }

    /**
     * Siapkan data permohonan untuk disimpan
     */
    public function preparePermohonanData(array $validatedData, array $uploadedFiles, string $nomorPermohonan): array
    {
        return [
            'nomor_permohonan' => $nomorPermohonan,
            'jenis_layanan' => $validatedData['jenis_layanan'],
            'nama_pemohon' => trim($validatedData['nama']),
            'nik' => $validatedData['nik'],
            'email' => strtolower(trim($validatedData['email'])),
            'telepon' => preg_replace('/[^\d+]/', '', $validatedData['telepon']),
            'alamat' => trim($validatedData['alamat']),
            'deskripsi' => trim($validatedData['deskripsi']),
            'keperluan' => trim($validatedData['deskripsi']), // Untuk kompatibilitas
            'dokumen_persyaratan' => $uploadedFiles,
            'status' => 'Diajukan',
            'tanggal_permohonan' => now(),
            'metadata' => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'submission_time' => now()->toISOString()
            ]
        ];
    }

    /**
     * Bersihkan file yang diupload jika terjadi error
     */
    public function cleanupFiles(array $uploadedFiles): void
    {
        foreach ($uploadedFiles as $file) {
            if (isset($file['path']) && Storage::disk('public')->exists($file['path'])) {
                Storage::disk('public')->delete($file['path']);
                Log::info('Cleaned up file', ['path' => $file['path']]);
            }
        }
    }

    /**
     * Get status badge class untuk UI
     */
    public function getStatusBadge(string $status): string
    {
        return self::STATUS_PERMOHONAN[$status] ?? 'badge-secondary';
    }

    /**
     * Dapatkan deskripsi lengkap jenis layanan
     */
    public function getJenisLayananDescription(string $jenisLayanan): string
    {
        return self::JENIS_LAYANAN[$jenisLayanan] ?? 'Layanan lainnya';
    }

    /**
     * Generate laporan permohonan untuk admin
     */
    public function generateReport(array $filters = []): array
    {
        $query = PermohonanLayanan::query();

        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['jenis_layanan'])) {
            $query->where('jenis_layanan', $filters['jenis_layanan']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $permohonan = $query->latest()->get();

        return [
            'total' => $permohonan->count(),
            'by_status' => $permohonan->groupBy('status')->map->count(),
            'by_jenis_layanan' => $permohonan->groupBy('jenis_layanan')->map->count(),
            'recent' => $permohonan->take(10),
            'data' => $permohonan
        ];
    }
}
