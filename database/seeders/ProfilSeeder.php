<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profil;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profil::create([
            'nama_instansi' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan',
            'visi' => 'Terwujudnya infrastruktur yang berkualitas dan penataan ruang yang optimal untuk mendukung pembangunan berkelanjutan di Kabupaten Katingan.',
            'misi' => "1. Meningkatkan kualitas infrastruktur jalan, jembatan, dan bangunan air untuk mendukung konektivitas dan perekonomian daerah.
2. Melaksanakan penataan ruang yang terencana dan terintegrasi sesuai dengan rencana tata ruang wilayah.
3. Meningkatkan pelayanan publik di bidang perizinan dan pengawasan bangunan gedung.
4. Mengembangkan sumber daya manusia yang profesional dan kompeten di bidang pekerjaan umum dan penataan ruang.
5. Menerapkan teknologi dan inovasi dalam pelaksanaan pembangunan infrastruktur.",
            'tupoksi' => "TUGAS POKOK:
Melaksanakan urusan pemerintahan daerah di bidang pekerjaan umum dan penataan ruang sesuai dengan asas otonomi dan tugas pembantuan.

FUNGSI:
1. Perumusan kebijakan teknis bidang pekerjaan umum dan penataan ruang
2. Penyelenggaraan urusan pemerintahan dan pelayanan umum bidang pekerjaan umum dan penataan ruang
3. Pembinaan dan pelaksanaan tugas bidang pekerjaan umum dan penataan ruang
4. Pelaksanaan tugas lain yang diberikan oleh Bupati sesuai dengan tugas dan fungsinya",
            'sejarah' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan dibentuk berdasarkan Peraturan Daerah untuk menangani pembangunan infrastruktur dan penataan ruang di wilayah Kabupaten Katingan, Kalimantan Tengah.',
            'motto' => 'Membangun dengan Integritas, Melayani dengan Dedikasi',
            'nilai_nilai' => "1. INTEGRITAS - Jujur, konsisten, dan dapat dipercaya
2. PROFESIONAL - Kompeten dan berkualitas dalam bekerja  
3. INOVATIF - Kreatif dan selalu mencari solusi terbaik
4. RESPONSIF - Tanggap terhadap kebutuhan masyarakat
5. AKUNTABEL - Bertanggung jawab atas setiap tindakan",
            'alamat' => 'Jl. A. Yani KM. 2, Kasongan, Kabupaten Katingan, Kalimantan Tengah',
            'telepon' => '(0536) 21234',
            'email' => 'dinaspu@katingankab.go.id',
            'website' => 'https://dinaspu.katingankab.go.id',
            'jam_operasional' => 'Senin - Jumat: 08:00 - 16:00 WIB',
            'status' => 'aktif',
            'user_id' => 1
        ]);
    }
}
