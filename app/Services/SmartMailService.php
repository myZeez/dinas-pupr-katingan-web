<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\GmailTransport;

class SmartMailService
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'password' => config('mail.mailers.smtp.password'),
            'encryption' => config('mail.mailers.smtp.encryption'),
        ];
    }

    public function sendEmail($to, $subject, $message, $attachments = [])
    {
        try {
            Mail::send([], [], function ($mail) use ($to, $subject, $message, $attachments) {
                $mail->to($to)
                    ->subject($subject)
                    ->html($message);

                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $mail->attach($attachment);
                    }
                }
            });

            Log::info('Email sent successfully', [
                'to' => $to,
                'subject' => $subject
            ]);

            return [
                'success' => true,
                'message' => 'Email sent successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ];
        }
    }

    public function sendBulkEmail($recipients, $subject, $message)
    {
        $results = [];

        foreach ($recipients as $recipient) {
            $result = $this->sendEmail($recipient, $subject, $message);
            $results[$recipient] = $result;
        }

        return $results;
    }

    public function testConnection()
    {
        try {
            // Test connection by attempting to send a test email to a dummy address
            Mail::raw('Test connection', function ($message) {
                $message->to('test@example.com')
                    ->subject('SMTP Connection Test');
            });

            return [
                'success' => true,
                'message' => 'SMTP connection successful'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'SMTP connection failed: ' . $e->getMessage()
            ];
        }
    }
}
