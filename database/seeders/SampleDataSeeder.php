<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Program;
use App\Models\Struktur;
use App\Models\Profil;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Berita
        Berita::create([
            'judul' => 'Pembangunan Jembatan Sei Samba Tahap II Dimulai',
            'slug' => 'pembangunan-jembatan-sei-samba-tahap-ii-dimulai',
            'konten' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan memulai pembangunan tahap II jembatan Sei Samba. Proyek ini diharapkan dapat meningkatkan konektivitas antar wilayah dan mendukung pertumbuhan ekonomi masyarakat. Pembangunan dilakukan dengan standar konstruksi yang tinggi untuk memastikan keamanan dan durabilitas jembatan.',
            'tanggal' => now()->subDays(5),
        ]);

        Berita::create([
            'judul' => 'Perbaikan Jalan Provinsi KM 15-25 Selesai Dilaksanakan',
            'slug' => 'perbaikan-jalan-provinsi-km-15-25-selesai-dilaksanakan',
            'konten' => 'Perbaikan jalan provinsi sepanjang 10 kilometer telah selesai dilaksanakan dengan anggaran APBD Kabupaten Katingan. Perbaikan meliputi pengaspalan ulang, perbaikan drainase, dan pemasangan rambu-rambu lalu lintas. Dengan selesainya perbaikan ini, diharapkan akses transportasi menjadi lebih lancar dan aman.',
            'tanggal' => now()->subDays(10),
        ]);

        // Sample Program
        Program::create([
            'nama_program' => 'Pembangunan Infrastruktur Jalan Desa',
            'deskripsi' => 'Program pembangunan dan perbaikan jalan desa di 15 kecamatan se-Kabupaten Katingan untuk meningkatkan akses transportasi masyarakat.',
            'status' => 'Berjalan',
            'lokasi' => 'Kabupaten Katingan',
            'tanggal_mulai' => now()->subMonths(2),
            'tanggal_selesai' => now()->addMonths(4),
        ]);

        Program::create([
            'nama_program' => 'Rehabilitasi Drainase Kota Kasongan',
            'deskripsi' => 'Program rehabilitasi sistem drainase di Kota Kasongan untuk mengatasi masalah banjir dan genangan air.',
            'status' => 'Perencanaan',
            'lokasi' => 'Kota Kasongan',
            'tanggal_mulai' => now()->addMonth(),
            'tanggal_selesai' => now()->addMonths(8),
        ]);

        // Sample Struktur
        Struktur::create([
            'nama' => 'Ir. Ahmad Hidayat, M.T.',
            'jabatan' => 'Kepala Dinas PUPR',
            'urutan' => 1,
        ]);

        Struktur::create([
            'nama' => 'Ir. Sari Dewi, S.T.',
            'jabatan' => 'Sekretaris Dinas',
            'urutan' => 2,
        ]);

        Struktur::create([
            'nama' => 'Ir. Bambang Priyono, M.T.',
            'jabatan' => 'Kabid Bina Marga',
            'urutan' => 3,
        ]);

        // Sample Profil
        Profil::create([
            'jenis' => 'Visi',
            'isi' => 'Terwujudnya infrastruktur yang berkualitas dan berkelanjutan untuk mendukung kesejahteraan masyarakat Kabupaten Katingan.',
        ]);

        Profil::create([
            'jenis' => 'Misi',
            'isi' => '1. Meningkatkan kualitas infrastruktur jalan, jembatan, dan drainase
2. Melaksanakan penataan ruang yang terencana dan berkelanjutan
3. Memberikan pelayanan publik yang prima dan transparans
4. Mengembangkan sumber daya manusia yang professional dan kompeten',
        ]);

        Profil::create([
            'jenis' => 'Tupoksi',
            'isi' => 'Tugas Pokok dan Fungsi Dinas PUPR:
1. Melaksanakan urusan pemerintahan bidang pekerjaan umum dan penataan ruang
2. Pembinaan teknis bidang infrastruktur jalan dan jembatan
3. Pengelolaan sistem drainase dan pengairan
4. Penataan ruang wilayah kabupaten
5. Pengawasan dan pengendalian pembangunan',
        ]);
    }
}
