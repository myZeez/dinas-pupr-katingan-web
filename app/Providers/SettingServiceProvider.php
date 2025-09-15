<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            try {
                // Load mail settings from database
                $mailSettings = Setting::where('group', 'mail')->get();

                foreach ($mailSettings as $setting) {
                    switch ($setting->key) {
                        case 'mail_mailer':
                            Config::set('mail.default', $setting->value);
                            break;
                        case 'mail_host':
                            Config::set('mail.mailers.smtp.host', $setting->value);
                            break;
                        case 'mail_port':
                            Config::set('mail.mailers.smtp.port', (int) $setting->value);
                            break;
                        case 'mail_username':
                            Config::set('mail.mailers.smtp.username', $setting->value);
                            break;
                        case 'mail_password':
                            Config::set('mail.mailers.smtp.password', $setting->value);
                            break;
                        case 'mail_encryption':
                            Config::set('mail.mailers.smtp.encryption', $setting->value);
                            break;
                        case 'mail_from_address':
                            Config::set('mail.from.address', $setting->value);
                            break;
                        case 'mail_from_name':
                            Config::set('mail.from.name', $setting->value);
                            break;
                    }
                }
            } catch (\Exception $e) {
                // Silently fail if there's an issue with database or settings
            }
        }
    }
}
