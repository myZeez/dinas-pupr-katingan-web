<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programData = [
            [
                'nama_program' => 'Pembangunan Jalan Provinsi',
                'deskripsi' => 'Program pembangunan dan peningkatan kualitas jalan provinsi di wilayah Kabupaten Katingan untuk mendukung konektivitas antar daerah.',
                'status' => 'berjalan',
                'lokasi' => 'Jalan Trans Kalimantan Katingan',
                'tanggal_mulai' => now()->subDays(90),
                'tanggal_selesai' => now()->addDays(180),
                'created_at' => now()->subDays(95),
                'updated_at' => now()->subDays(10),
            ],
            [
                'nama_program' => 'Rehabilitasi Jembatan Kahayan',
                'deskripsi' => 'Program rehabilitasi dan perkuatan struktur jembatan di Sungai Kahayan untuk meningkatkan keselamatan dan daya dukung jembatan.',
                'status' => 'selesai',
                'lokasi' => 'Jembatan Kahayan, Kecamatan Katingan Tengah',
                'tanggal_mulai' => now()->subDays(200),
                'tanggal_selesai' => now()->subDays(30),
                'created_at' => now()->subDays(210),
                'updated_at' => now()->subDays(25),
            ],
            [
                'nama_program' => 'Program Perumahan Rakyat',
                'deskripsi' => 'Program penyediaan rumah layak huni bagi masyarakat berpenghasilan rendah di Kabupaten Katingan.',
                'status' => 'berjalan',
                'lokasi' => 'Desa Kereng Bangkirai, Kecamatan Katingan Kuala',
                'tanggal_mulai' => now()->subDays(60),
                'tanggal_selesai' => now()->addDays(300),
                'created_at' => now()->subDays(70),
                'updated_at' => now()->subDays(5),
            ],
            [
                'nama_program' => 'Sistem Drainase Perkotaan',
                'deskripsi' => 'Pembangunan sistem drainase untuk mengatasi masalah banjir dan genangan air di kawasan perkotaan Katingan.',
                'status' => 'perencanaan',
                'lokasi' => 'Kawasan Perkotaan Kasongan',
                'tanggal_mulai' => now()->addDays(30),
                'tanggal_selesai' => now()->addDays(365),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(2),
            ],
            [
                'nama_program' => 'Penataan Ruang Terbuka Hijau',
                'deskripsi' => 'Program pengembangan ruang terbuka hijau untuk mendukung kelestarian lingkungan dan kenyamanan kota.',
                'status' => 'berjalan',
                'lokasi' => 'Taman Kota Katingan',
                'tanggal_mulai' => now()->subDays(45),
                'tanggal_selesai' => now()->addDays(120),
                'created_at' => now()->subDays(50),
                'updated_at' => now()->subDays(7),
            ],
            [
                'nama_program' => 'Sanitasi Lingkungan',
                'deskripsi' => 'Program peningkatan sanitasi lingkungan melalui pembangunan infrastruktur pengelolaan air limbah dan sampah.',
                'status' => 'selesai',
                'lokasi' => 'Kecamatan Katingan Hilir',
                'tanggal_mulai' => now()->subDays(300),
                'tanggal_selesai' => now()->subDays(50),
                'created_at' => now()->subDays(310),
                'updated_at' => now()->subDays(45),
            ],
        ];

        foreach ($programData as $data) {
            Program::create($data);
        }
    }
}
