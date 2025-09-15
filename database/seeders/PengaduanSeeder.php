<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengaduanData = [
            [
                'nama' => 'Budi Prasetyo',
                'email' => 'budi.prasetyo@email.com',
                'telepon' => '0812-3456-7890',
                'kategori' => 'Infrastruktur Jalan',
                'pesan' => 'Jalan di Desa Kereng Bangkirai banyak yang berlubang dan membahayakan pengendara. Mohon segera diperbaiki.',
                'status' => 'Diproses',
                'tanggal_pengaduan' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(3),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'telepon' => '0813-9876-5432',
                'kategori' => 'Drainase',
                'pesan' => 'Saluran drainase di depan rumah saya tersumbat sampah sehingga sering terjadi genangan air saat hujan.',
                'status' => 'Baru',
                'tanggal_pengaduan' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@email.com',
                'telepon' => '0814-5678-9012',
                'kategori' => 'Perizinan',
                'pesan' => 'Saya sudah mengajukan IMB selama 2 bulan tapi belum ada kabar. Mohon informasi status permohonan saya.',
                'status' => 'Selesai',
                'tanggal_pengaduan' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(8),
            ],
            [
                'nama' => 'Dewi Kartika',
                'email' => 'dewi.kartika@email.com',
                'telepon' => '0815-2468-1357',
                'kategori' => 'Perumahan',
                'pesan' => 'Kapan program rumah bersubsidi di Kecamatan Katingan Kuala akan dibuka lagi? Saya sangat membutuhkan informasi ini.',
                'status' => 'Diproses',
                'tanggal_pengaduan' => now()->subDays(7),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(4),
            ],
            [
                'nama' => 'Rudi Hartono',
                'email' => 'rudi.hartono@email.com',
                'telepon' => '0816-1357-2468',
                'kategori' => 'Fasilitas Umum',
                'pesan' => 'Lampu penerangan jalan di Jalan Veteran mati semua, mohon segera diperbaiki untuk keamanan warga.',
                'status' => 'Baru',
                'tanggal_pengaduan' => now()->subDays(1),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'nama' => 'Lisa Permata',
                'email' => 'lisa.permata@email.com',
                'telepon' => '0817-3691-4702',
                'kategori' => 'Tata Ruang',
                'pesan' => 'Ada bangunan yang didirikan tanpa izin di kawasan hijau. Mohon ditindaklanjuti sesuai peraturan yang berlaku.',
                'status' => 'Diproses',
                'tanggal_pengaduan' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(6),
            ],
            [
                'nama' => 'Muhammad Hasan',
                'email' => 'muhammad.hasan@email.com',
                'telepon' => '0818-7410-8520',
                'kategori' => 'Infrastruktur Jalan',
                'pesan' => 'Jembatan di Desa Tumbang Samba sudah mulai retak dan berbahaya untuk dilalui kendaraan berat.',
                'status' => 'Selesai',
                'tanggal_pengaduan' => now()->subDays(20),
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(12),
            ],
        ];

        foreach ($pengaduanData as $data) {
            Pengaduan::create($data);
        }
    }
}
