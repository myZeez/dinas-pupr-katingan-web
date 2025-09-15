<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PublicContent;

class PublicContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Carousel Slides
        PublicContent::create([
            'key' => 'carousel_slide',
            'title' => 'Pembangunan Infrastruktur Jalan',
            'content' => 'Dinas PUPR Kabupaten Katingan berkomitmen membangun infrastruktur jalan yang berkualitas untuk menunjang konektivitas dan mobilitas masyarakat.',
            'order' => 1,
            'is_active' => true,
            'metadata' => [
                'button_text' => 'Selengkapnya',
                'button_link' => '#program'
            ]
        ]);

        PublicContent::create([
            'key' => 'carousel_slide',
            'title' => 'Irigasi untuk Pertanian',
            'content' => 'Membangun dan memperbaiki sistem irigasi untuk mendukung sektor pertanian dan ketahanan pangan di Kabupaten Katingan.',
            'order' => 2,
            'is_active' => true,
            'metadata' => [
                'button_text' => 'Lihat Program',
                'button_link' => '#layanan'
            ]
        ]);

        PublicContent::create([
            'key' => 'carousel_slide',
            'title' => 'Drainase dan Pengendalian Banjir',
            'content' => 'Sistem drainase yang baik untuk mencegah genangan air dan banjir di wilayah Kabupaten Katingan.',
            'order' => 3,
            'is_active' => true,
            'metadata' => [
                'button_text' => 'Info Lengkap',
                'button_link' => '#berita'
            ]
        ]);

        // Hero Video
        PublicContent::create([
            'key' => 'hero_video',
            'title' => 'Video Profil Dinas PUPR Katingan',
            'content' => 'Mengenal lebih dekat Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan',
            'order' => 1,
            'is_active' => true,
            'metadata' => [
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ]
        ]);

        // Statistics Counters
        PublicContent::create([
            'key' => 'stats_counter',
            'title' => 'Total Proyek',
            'content' => '250+',
            'order' => 1,
            'is_active' => true,
            'metadata' => [
                'icon' => 'building',
                'color' => 'primary'
            ]
        ]);

        PublicContent::create([
            'key' => 'stats_counter',
            'title' => 'Jalan Dibangun',
            'content' => '120',
            'order' => 2,
            'is_active' => true,
            'metadata' => [
                'icon' => 'road',
                'color' => 'success'
            ]
        ]);

        PublicContent::create([
            'key' => 'stats_counter',
            'title' => 'Jaringan Irigasi',
            'content' => '85',
            'order' => 3,
            'is_active' => true,
            'metadata' => [
                'icon' => 'droplet',
                'color' => 'info'
            ]
        ]);

        PublicContent::create([
            'key' => 'stats_counter',
            'title' => 'Desa Terlayani',
            'content' => '150+',
            'order' => 4,
            'is_active' => true,
            'metadata' => [
                'icon' => 'geo-alt',
                'color' => 'warning'
            ]
        ]);

        // Hero Video
        PublicContent::create([
            'key' => 'hero_video',
            'title' => 'Profil Dinas PUPR Katingan',
            'content' => 'Video profil Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan',
            'order' => 1,
            'is_active' => true,
            'metadata' => [
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ]
        ]);

        // Leader Photo
        PublicContent::create([
            'key' => 'leader_photo',
            'title' => 'Ir. John Doe, M.T.',
            'content' => 'Kepala Dinas PUPR Kabupaten Katingan yang berpengalaman dalam pembangunan infrastruktur.',
            'order' => 1,
            'is_active' => true,
            'metadata' => [
                'position' => 'Kepala Dinas PUPR',
                'period' => '2020-2025'
            ]
        ]);

        // Partner Logos
        $partners = [
            ['name' => 'Kementerian PUPR', 'description' => 'Kerjasama dengan Kementerian PUPR RI'],
            ['name' => 'Pemprov Kalteng', 'description' => 'Kerjasama dengan Pemerintah Provinsi Kalimantan Tengah'],
            ['name' => 'BBWS Kahayan', 'description' => 'Kerjasama dengan Balai Besar Wilayah Sungai Kahayan'],
            ['name' => 'Universitas Palangka Raya', 'description' => 'Kerjasama penelitian dan pengembangan'],
            ['name' => 'Bank Indonesia', 'description' => 'Kerjasama pengembangan ekonomi daerah'],
            ['name' => 'BPJN Kalteng', 'description' => 'Kerjasama pembangunan jalan nasional']
        ];

        foreach ($partners as $index => $partner) {
            PublicContent::create([
                'key' => 'partner_logo',
                'title' => $partner['name'],
                'content' => $partner['description'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        // Testimonials
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'content' => 'Pembangunan jalan di desa kami sangat membantu akses transportasi. Terima kasih Dinas PUPR!'
            ],
            [
                'name' => 'Siti Aminah',
                'content' => 'Sistem irigasi yang dibangun sangat membantu petani di daerah kami. Hasil panen meningkat!'
            ],
            [
                'name' => 'Ahmad Rahman',
                'content' => 'Pelayanan perizinan di Dinas PUPR sangat cepat dan profesional. Sangat puas!'
            ]
        ];

        foreach ($testimonials as $index => $testimonial) {
            PublicContent::create([
                'key' => 'testimonial',
                'title' => $testimonial['name'],
                'content' => $testimonial['content'],
                'order' => $index + 1,
                'is_active' => true
            ]);
        }

        // Announcements
        PublicContent::create([
            'key' => 'announcement',
            'title' => 'Pengumuman Tender Proyek Jalan',
            'content' => 'Tender untuk proyek pembangunan jalan sepanjang 25 km di wilayah Kecamatan Katingan Tengah telah dibuka.',
            'link' => '#',
            'order' => 1,
            'is_active' => true
        ]);

        PublicContent::create([
            'key' => 'announcement',
            'title' => 'Pemeliharaan Rutin Infrastruktur',
            'content' => 'Jadwal pemeliharaan rutin infrastruktur jalan dan jembatan untuk bulan ini.',
            'link' => '#',
            'order' => 2,
            'is_active' => true
        ]);
    }
}
