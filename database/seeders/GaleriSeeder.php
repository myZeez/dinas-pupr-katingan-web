<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeriData = [
            [
                'judul' => 'Pembangunan Jalan Raya Katingan',
                'deskripsi' => 'Dokumentasi proses pembangunan jalan raya yang menghubungkan pusat kota dengan daerah terpencil',
                'tipe' => 'foto',
                'file_path' => 'galeri/jalan-raya-1.jpg',
                'file_name' => 'jalan-raya-1.jpg',
                'file_size' => 1024000,
                'status' => 'aktif',
                'kategori' => 'infrastruktur',
                'urutan' => 1,
                'views' => 45,
                'user_id' => 1,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'judul' => 'Perbaikan Sistem Drainase',
                'deskripsi' => 'Foto kegiatan perbaikan sistem drainase di pusat kota Katingan',
                'tipe' => 'foto',
                'file_path' => 'galeri/drainase-1.jpg',
                'file_name' => 'drainase-1.jpg',
                'file_size' => 856000,
                'status' => 'aktif',
                'kategori' => 'drainase',
                'urutan' => 2,
                'views' => 32,
                'user_id' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'judul' => 'Renovasi Gedung Kantor',
                'deskripsi' => 'Proses renovasi gedung kantor Dinas PUPR Kabupaten Katingan',
                'tipe' => 'foto',
                'file_path' => 'galeri/renovasi-kantor-1.jpg',
                'file_name' => 'renovasi-kantor-1.jpg',
                'file_size' => 712000,
                'status' => 'aktif',
                'kategori' => 'fasilitas',
                'urutan' => 3,
                'views' => 28,
                'user_id' => 1,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Program Rumah Layak Huni',
                'deskripsi' => 'Dokumentasi program bantuan rumah layak huni untuk masyarakat',
                'tipe' => 'foto',
                'file_path' => 'galeri/rumah-layak-huni-1.jpg',
                'file_name' => 'rumah-layak-huni-1.jpg',
                'file_size' => 945000,
                'status' => 'aktif',
                'kategori' => 'perumahan',
                'urutan' => 4,
                'views' => 67,
                'user_id' => 1,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'judul' => 'Sosialisasi Tata Ruang',
                'deskripsi' => 'Kegiatan sosialisasi RTRW Kabupaten Katingan kepada masyarakat',
                'tipe' => 'foto',
                'file_path' => 'galeri/sosialisasi-rtrw-1.jpg',
                'file_name' => 'sosialisasi-rtrw-1.jpg',
                'file_size' => 634000,
                'status' => 'aktif',
                'kategori' => 'tata_ruang',
                'urutan' => 5,
                'views' => 41,
                'user_id' => 1,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'judul' => 'Pembangunan Jembatan',
                'deskripsi' => 'Proses pembangunan jembatan penghubung antar desa',
                'tipe' => 'foto',
                'file_path' => 'galeri/jembatan-1.jpg',
                'file_name' => 'jembatan-1.jpg',
                'file_size' => 1156000,
                'status' => 'aktif',
                'kategori' => 'infrastruktur',
                'urutan' => 6,
                'views' => 53,
                'user_id' => 1,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
        ];

        foreach ($galeriData as $data) {
            Galeri::create($data);
        }
    }
}
