<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisiMisi::create([
            'visi' => 'Terwujudnya infrastruktur yang berkualitas dan tata ruang yang berkelanjutan untuk mendukung kesejahteraan masyarakat Kabupaten Katingan.',
            'misi' => "1. Meningkatkan kualitas infrastruktur jalan, jembatan, dan fasilitas umum yang memadai dan berkelanjutan.\n\n2. Mengembangkan sistem penataan ruang yang terpadu dan berwawasan lingkungan.\n\n3. Meningkatkan pelayanan perizinan yang transparan, akuntabel, dan berbasis teknologi.\n\n4. Mendorong pembangunan perumahan yang layak huni bagi seluruh masyarakat.\n\n5. Memperkuat kapasitas sumber daya manusia dalam bidang pekerjaan umum dan penataan ruang.\n\n6. Meningkatkan partisipasi masyarakat dalam pembangunan infrastruktur dan penataan ruang.",
            'tupoksi' => "TUGAS POKOK:\nDinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan mempunyai tugas membantu Bupati dalam melaksanakan urusan pemerintahan di bidang pekerjaan umum dan penataan ruang yang menjadi kewenangan daerah.\n\nFUNGSI:\n1. Perumusan kebijakan teknis di bidang pekerjaan umum dan penataan ruang\n2. Pelaksanaan kebijaan di bidang pekerjaan umum dan penataan ruang\n3. Pelaksanaan evaluasi dan pelaporan di bidang pekerjaan umum dan penataan ruang\n4. Pelaksanaan administrasi dinas di bidang pekerjaan umum dan penataan ruang\n5. Pelaksanaan fungsi lain yang diberikan oleh Bupati terkait dengan tugas dan fungsinya",
            'deskripsi' => 'Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) Kabupaten Katingan adalah instansi pemerintah daerah yang bertanggung jawab dalam penyelenggaraan urusan pemerintahan di bidang pekerjaan umum dan penataan ruang. Dinas ini berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat dalam rangka mewujudkan infrastruktur yang berkualitas dan tata ruang yang berkelanjutan.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
