<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaptchaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class CaptchaSettingController extends Controller
{
    public function index()
    {
        $settings = CaptchaSetting::orderBy('key')->get();

        // Jika belum ada settings, buat default
        if ($settings->isEmpty()) {
            $this->createDefaultSettings();
            $settings = CaptchaSetting::orderBy('key')->get();
        }

        return view('admin.captcha.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            $setting = CaptchaSetting::where('key', $key)->first();

            if ($setting) {
                // Handle boolean values
                if ($setting->type === 'boolean') {
                    $value = $request->has("settings.{$key}") ? '1' : '0';
                }

                $setting->update(['value' => $value]);
                Cache::forget("captcha_setting_{$key}");
            }
        }

        // Clear all captcha cache
        CaptchaSetting::clearCache();

        // Clear Laravel config cache
        Artisan::call('config:clear');

        return redirect()->route('admin.captcha.index')
            ->with('success', 'Pengaturan CAPTCHA berhasil diperbarui.');
    }

    public function test()
    {
        try {
            $sitekey = CaptchaSetting::getValue('nocaptcha_sitekey');
            $secret = CaptchaSetting::getValue('nocaptcha_secret');
            $required = CaptchaSetting::getValue('captcha_required', true);

            return response()->json([
                'success' => true,
                'data' => [
                    'sitekey_length' => strlen($sitekey),
                    'secret_length' => strlen($secret),
                    'required' => $required,
                    'sitekey_format' => strpos($sitekey, '6L') === 0 ? 'Valid' : 'Invalid',
                    'secret_format' => strpos($secret, '6L') === 0 ? 'Valid' : 'Invalid'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function createDefaultSettings()
    {
        $defaults = [
            [
                'key' => 'nocaptcha_sitekey',
                'value' => env('NOCAPTCHA_SITEKEY', ''),
                'type' => 'text',
                'label' => 'Site Key',
                'description' => 'Google reCAPTCHA Site Key (Client-side)',
                'is_sensitive' => false
            ],
            [
                'key' => 'nocaptcha_secret',
                'value' => env('NOCAPTCHA_SECRET', ''),
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

        foreach ($defaults as $setting) {
            CaptchaSetting::create($setting);
        }
    }
}
