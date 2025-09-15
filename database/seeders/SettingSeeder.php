<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Pengaturan Website Umum
            [
                'key' => 'site_name',
                'value' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nama website/instansi'
            ],
            [
                'key' => 'site_description',
                'value' => 'Website resmi Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Deskripsi website'
            ],
            [
                'key' => 'site_keywords',
                'value' => 'dinas pupr, katingan, infrastruktur, tata ruang, pekerjaan umum',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Keywords untuk SEO'
            ],
            [
                'key' => 'admin_email',
                'value' => 'admin@dinaspupr-katingan.go.id',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Email administrator'
            ],
            [
                'key' => 'contact_phone',
                'value' => '(0536) 21234',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Nomor telepon kantor'
            ],
            [
                'key' => 'contact_fax',
                'value' => '(0536) 21235',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Nomor fax kantor'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Jenderal Sudirman No. 123, Kasongan, Kabupaten Katingan, Kalimantan Tengah',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Alamat kantor'
            ],

            // Pengaturan Media Sosial
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/dinaspupr.katingan',
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Facebook'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/dinaspupr.katingan',
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Instagram'
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/@dinaspuprkatingan',
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL YouTube'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/dinaspupr_ktg',
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Twitter/X'
            ],

            // Pengaturan Tampilan
            [
                'key' => 'logo_header',
                'value' => 'logo-katingan.png',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Logo di header website'
            ],
            [
                'key' => 'favicon',
                'value' => 'favicon.ico',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Icon website'
            ],
            [
                'key' => 'theme_color',
                'value' => '#2563eb',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Warna tema website'
            ],

            // Pengaturan Konten
            [
                'key' => 'posts_per_page',
                'value' => '10',
                'type' => 'integer',
                'group' => 'content',
                'description' => 'Jumlah berita per halaman'
            ],
            [
                'key' => 'auto_publish',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'content',
                'description' => 'Publikasi otomatis berita'
            ],
            [
                'key' => 'comment_moderation',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'content',
                'description' => 'Moderasi komentar'
            ],

            // Pengaturan Notifikasi
            [
                'key' => 'email_notifications',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Notifikasi email'
            ],
            [
                'key' => 'notification_email',
                'value' => 'notifikasi@dinaspupr-katingan.go.id',
                'type' => 'string',
                'group' => 'notifications',
                'description' => 'Email untuk notifikasi'
            ],

            // Pengaturan Upload
            [
                'key' => 'max_file_size',
                'value' => '10240',
                'type' => 'integer',
                'group' => 'upload',
                'description' => 'Ukuran maksimal file upload (KB)'
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'type' => 'string',
                'group' => 'upload',
                'description' => 'Tipe file yang diizinkan'
            ],

            // Pengaturan Jam Operasional
            [
                'key' => 'office_hours',
                'value' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Jam operasional kantor'
            ],

            // Pengaturan Maps
            [
                'key' => 'google_maps_api_key',
                'value' => '',
                'type' => 'string',
                'group' => 'maps',
                'description' => 'API Key Google Maps'
            ],
            [
                'key' => 'office_latitude',
                'value' => '-1.5456789',
                'type' => 'string',
                'group' => 'maps',
                'description' => 'Latitude kantor'
            ],
            [
                'key' => 'office_longitude',
                'value' => '112.9876543',
                'type' => 'string',
                'group' => 'maps',
                'description' => 'Longitude kantor'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
