<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CaptchaSetting;

class CaptchaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'nocaptcha_sitekey',
                'value' => env('NOCAPTCHA_SITEKEY', '6LlfJ8QrAAAAANWw0KNSZYvPak3GiD6fx2i7jGxM'),
                'type' => 'text',
                'label' => 'Site Key',
                'description' => 'Google reCAPTCHA Site Key (Client-side)',
                'is_sensitive' => false
            ],
            [
                'key' => 'nocaptcha_secret',
                'value' => env('NOCAPTCHA_SECRET', '6LlfJ8QrAAAAANpsBaGKLRlye4AKv5gtEQSlOSwH'),
                'type' => 'text',
                'label' => 'Secret Key',
                'description' => 'Google reCAPTCHA Secret Key (Server-side)',
                'is_sensitive' => true
            ],
            [
                'key' => 'nocaptcha_version',
                'value' => env('NOCAPTCHA_VERSION', '2'),
                'type' => 'select',
                'label' => 'reCAPTCHA Version',
                'description' => 'Versi reCAPTCHA yang digunakan',
                'options' => ['2' => 'v2 (Checkbox)', '3' => 'v3 (Invisible)']
            ],
            [
                'key' => 'captcha_required',
                'value' => env('CAPTCHA_REQUIRED', '1'),
                'type' => 'boolean',
                'label' => 'CAPTCHA Required',
                'description' => 'Aktifkan CAPTCHA di form public'
            ],
            [
                'key' => 'nocaptcha_enterprise',
                'value' => env('NOCAPTCHA_ENTERPRISE', '0'),
                'type' => 'boolean',
                'label' => 'Enterprise Mode',
                'description' => 'Gunakan reCAPTCHA Enterprise (memerlukan kunci Enterprise)'
            ]
        ];

        foreach ($settings as $setting) {
            CaptchaSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
