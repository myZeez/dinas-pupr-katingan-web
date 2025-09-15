<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videoData = [
            [
                'title' => 'Profil Dinas PUPR Kabupaten Katingan',
                'description' => 'Video profil Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan yang menampilkan visi, misi, dan program kerja.',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_id' => 'dQw4w9WgXcQ',
                'video_file' => null,
                'thumbnail' => 'videos/thumbnails/profil-dinas.jpg',
                'category' => 'profil',
                'is_active' => true,
                'views' => 156,
                'user_id' => 1,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'title' => 'Pembangunan Infrastruktur Jalan 2024',
                'description' => 'Dokumentasi pembangunan infrastruktur jalan di berbagai wilayah Kabupaten Katingan tahun 2024.',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'youtube_id' => 'ScMzIvxBSi4',
                'video_file' => null,
                'thumbnail' => 'videos/thumbnails/infrastruktur-jalan.jpg',
                'category' => 'infrastruktur',
                'is_active' => true,
                'views' => 89,
                'user_id' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Program Perumahan Rakyat',
                'description' => 'Video mengenai program perumahan rakyat yang diselenggarakan oleh Dinas PUPR untuk meningkatkan kesejahteraan masyarakat.',
                'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'youtube_id' => '9bZkp7q19f0',
                'video_file' => null,
                'thumbnail' => 'videos/thumbnails/perumahan-rakyat.jpg',
                'category' => 'perumahan',
                'is_active' => true,
                'views' => 124,
                'user_id' => 1,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'title' => 'Sosialisasi Tata Ruang Wilayah',
                'description' => 'Kegiatan sosialisasi Rencana Tata Ruang Wilayah (RTRW) Kabupaten Katingan kepada masyarakat.',
                'youtube_url' => 'https://www.youtube.com/watch?v=astISOttCQ0',
                'youtube_id' => 'astISOttCQ0',
                'video_file' => null,
                'thumbnail' => 'videos/thumbnails/sosialisasi-rtrw.jpg',
                'category' => 'tata_ruang',
                'is_active' => true,
                'views' => 67,
                'user_id' => 1,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
        ];

        foreach ($videoData as $data) {
            Video::create($data);
        }
    }
}
