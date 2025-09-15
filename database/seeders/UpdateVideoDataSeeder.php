<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicContentNew;

class UpdateVideoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing video data or create new ones
        $videos = [
            [
                'tipe' => 'video',
                'judul' => 'Profil Dinas PUPR Katingan',
                'deskripsi' => 'Video profil lengkap Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan yang menampilkan visi, misi, dan program kerja dinas.',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_id' => 'dQw4w9WgXcQ',
                'urutan' => 1,
                'status' => 'aktif',
                'user_id' => 2
            ],
            [
                'tipe' => 'video',
                'judul' => 'Pembangunan Infrastruktur Katingan',
                'deskripsi' => 'Dokumentasi pembangunan infrastruktur jalan dan jembatan di Kabupaten Katingan tahun 2024.',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'youtube_id' => 'ScMzIvxBSi4',
                'urutan' => 2,
                'status' => 'aktif',
                'user_id' => 2
            ]
        ];

        foreach ($videos as $videoData) {
            PublicContentNew::updateOrCreate(
                [
                    'tipe' => $videoData['tipe'],
                    'judul' => $videoData['judul']
                ],
                $videoData
            );
        }

        $this->command->info('Video data updated successfully!');
    }
}
