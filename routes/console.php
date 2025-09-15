<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test:email', function () {
    $email = $this->ask('Masukkan email tujuan');
    $this->info('Mengirim test email ke: ' . $email);

    try {
        \Illuminate\Support\Facades\Mail::raw('Test email dari Laravel. Jika Anda menerima email ini, konfigurasi SMTP berfungsi dengan baik.', function ($message) use ($email) {
            $message->to($email)
                ->subject('Test Email - Laravel SMTP Configuration');
        });

        $this->info('✅ Email berhasil dikirim!');
    } catch (\Exception $e) {
        $this->error('❌ Gagal mengirim email: ' . $e->getMessage());
    }
})->purpose('Test email configuration');

Artisan::command('config:email', function () {
    $this->info('=== KONFIGURASI EMAIL SAAT INI ===');
    $this->table(['Setting', 'Value'], [
        ['MAIL_MAILER', config('mail.default')],
        ['MAIL_HOST', config('mail.mailers.smtp.host')],
        ['MAIL_PORT', config('mail.mailers.smtp.port')],
        ['MAIL_USERNAME', config('mail.mailers.smtp.username')],
        ['MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption')],
        ['MAIL_FROM_ADDRESS', config('mail.from.address')],
        ['MAIL_FROM_NAME', config('mail.from.name')],
    ]);
})->purpose('Show email configuration');
