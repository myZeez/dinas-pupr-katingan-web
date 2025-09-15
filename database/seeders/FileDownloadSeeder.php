<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FileDownload;

class FileDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileDownloads = [
            [
                'nama_file' => 'Peraturan Daerah tentang RTRW Kabupaten Katingan',
                'deskripsi' => 'Dokumen Peraturan Daerah Kabupaten Katingan tentang Rencana Tata Ruang Wilayah (RTRW) periode 2021-2041.',
                'file_path' => 'downloads/perda-rtrw-katingan-2021-2041.pdf',
                'file_name' => 'perda-rtrw-katingan-2021-2041.pdf',
                'file_size' => '2048576', // 2MB
                'file_type' => 'application/pdf',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 89,
                'urutan' => 1,
                'user_id' => 1,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(15),
            ],
            [
                'nama_file' => 'Standar Operasional Prosedur (SOP) Perizinan',
                'deskripsi' => 'Dokumen SOP untuk proses perizinan di Dinas PUPR Kabupaten Katingan.',
                'file_path' => 'downloads/sop-perizinan-pupr.pdf',
                'file_name' => 'sop-perizinan-pupr.pdf',
                'file_size' => '1536000', // 1.5MB
                'file_type' => 'application/pdf',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 156,
                'urutan' => 2,
                'user_id' => 1,
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(12),
            ],
            [
                'nama_file' => 'Laporan Kinerja Tahunan 2023',
                'deskripsi' => 'Laporan Kinerja Instansi Pemerintah (LKjIP) Dinas PUPR Kabupaten Katingan tahun 2023.',
                'file_path' => 'downloads/lkjip-pupr-2023.pdf',
                'file_name' => 'lkjip-pupr-2023.pdf',
                'file_size' => '4194304', // 4MB
                'file_type' => 'application/pdf',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 67,
                'urutan' => 3,
                'user_id' => 1,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(10),
            ],
            [
                'nama_file' => 'Formulir Permohonan Izin Mendirikan Bangunan (IMB)',
                'deskripsi' => 'Formulir untuk permohonan Izin Mendirikan Bangunan (IMB) di Kabupaten Katingan.',
                'file_path' => 'downloads/formulir-imb.doc',
                'file_name' => 'formulir-imb.doc',
                'file_size' => '512000', // 500KB
                'file_type' => 'application/msword',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 234,
                'urutan' => 4,
                'user_id' => 1,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(8),
            ],
            [
                'nama_file' => 'Panduan Teknis Pembangunan Infrastruktur',
                'deskripsi' => 'Panduan teknis untuk pembangunan infrastruktur jalan dan jembatan di Kabupaten Katingan.',
                'file_path' => 'downloads/panduan-teknis-infrastruktur.pdf',
                'file_name' => 'panduan-teknis-infrastruktur.pdf',
                'file_size' => '3145728', // 3MB
                'file_type' => 'application/pdf',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 123,
                'urutan' => 5,
                'user_id' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(7),
            ],
            [
                'nama_file' => 'Data Spasial Kabupaten Katingan',
                'deskripsi' => 'Data spasial dalam format shapefile untuk wilayah Kabupaten Katingan.',
                'file_path' => 'downloads/data-spasial-katingan.zip',
                'file_name' => 'data-spasial-katingan.zip',
                'file_size' => '10485760', // 10MB
                'file_type' => 'application/zip',
                'kategori' => 'dokumen',
                'status' => 'aktif',
                'download_count' => 45,
                'urutan' => 6,
                'user_id' => 1,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(5),
            ],
        ];

        foreach ($fileDownloads as $data) {
            FileDownload::create($data);
        }
    }
}
