<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--subject=Test Email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $subject = $this->option('subject');

        $this->info("Testing email configuration...");
        $this->info("To: {$email}");
        $this->info("Subject: {$subject}");

        try {
            // Test simple email
            Mail::raw('This is a test email from Dinas PUPR System.', function ($message) use ($email, $subject) {
                $message->to($email)
                    ->subject($subject);
            });

            $this->info("✅ Email sent successfully!");
            $this->info("Please check your inbox (and spam folder).");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email:");
            $this->error($e->getMessage());

            // Log the error
            Log::error('Test email failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
