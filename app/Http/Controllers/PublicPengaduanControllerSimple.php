<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PublicPengaduanControllerSimple extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Create pengaduan
            $pengaduan = Pengaduan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
                'status' => 'Baru',
            ]);

            DB::commit();

            // Send email notification - Simple Laravel Way
            $this->sendSimpleEmailNotification($pengaduan);

            return redirect()->back()->with('success', 'Pengaduan Anda berhasil dikirim. Kami akan segera menanggapi.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating pengaduan', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Send simple email notification - Laravel style like password reset
     */
    private function sendSimpleEmailNotification($pengaduan)
    {
        try {
            // Get admin emails
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin emails found', ['pengaduan_id' => $pengaduan->id]);
                return;
            }

            // Prepare email content
            $subject = "🚨 Pengaduan Baru: {$pengaduan->subjek}";

            // HTML Content
            $htmlContent = $this->getEmailHtmlContent($pengaduan);

            // Text Content (fallback)
            $textContent = $this->getEmailTextContent($pengaduan);

            // Send to each admin
            foreach ($adminEmails as $email) {
                $this->sendToAdmin($email, $subject, $htmlContent, $textContent, $pengaduan->id);
            }
        } catch (\Exception $e) {
            Log::error('Email notification failed', [
                'pengaduan_id' => $pengaduan->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email to single admin with fallback
     */
    private function sendToAdmin($email, $subject, $htmlContent, $textContent, $pengaduanId)
    {
        try {
            // Try SMTP first (like password reset)
            Mail::send([], [], function ($message) use ($email, $subject, $htmlContent) {
                $message->to($email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan')
                    ->html($htmlContent);
            });

            Log::info('Email sent via SMTP', ['to' => $email, 'pengaduan_id' => $pengaduanId]);
        } catch (\Exception $e) {
            // SMTP failed, use log fallback
            try {
                $originalDriver = config('mail.default');
                config(['mail.default' => 'log']);

                Mail::raw($textContent, function ($mail) use ($email, $subject) {
                    $mail->to($email)->subject($subject);
                });

                config(['mail.default' => $originalDriver]);

                Log::info('Email fallback to log', [
                    'to' => $email,
                    'pengaduan_id' => $pengaduanId,
                    'smtp_error' => $e->getMessage()
                ]);
            } catch (\Exception $e2) {
                Log::error('All email methods failed', [
                    'to' => $email,
                    'pengaduan_id' => $pengaduanId,
                    'smtp_error' => $e->getMessage(),
                    'log_error' => $e2->getMessage()
                ]);
            }
        }
    }

    /**
     * Get admin emails from database
     */
    private function getAdminEmails()
    {
        return User::whereIn('role', ['super_admin', 'admin'])
            ->whereNotNull('email')
            ->pluck('email')
            ->toArray();
    }

    /**
     * Get HTML email content
     */
    private function getEmailHtmlContent($pengaduan)
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f9fa;'>
            <div style='background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #2E8B57; margin-bottom: 20px; text-align: center; border-bottom: 3px solid #2E8B57; padding-bottom: 15px;'>
                    🚨 PENGADUAN BARU
                </h2>
                
                <div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                    <h3 style='color: #2E8B57; margin: 0;'>PUPR KATINGAN</h3>
                    <p style='color: #666; margin: 5px 0 0 0;'>Sistem Pengaduan Online</p>
                </div>
                
                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold; width: 25%;'>Nama</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>{$pengaduan->nama}</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Email</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>
                            <a href='mailto:{$pengaduan->email}' style='color: #007bff; text-decoration: none;'>{$pengaduan->email}</a>
                        </td>
                    </tr>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>No. HP</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>" . ($pengaduan->no_hp ?: '-') . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Subjek</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'><strong>{$pengaduan->subjek}</strong></td>
                    </tr>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Waktu</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>" . now()->format('d F Y, H:i') . " WIB</td>
                    </tr>
                </table>
                
                <div style='margin: 25px 0;'>
                    <h3 style='color: #2E8B57; margin-bottom: 10px;'>💬 Isi Pengaduan:</h3>
                    <div style='background-color: #ffffff; border: 1px solid #dee2e6; border-left: 5px solid #007bff; padding: 20px; border-radius: 5px; white-space: pre-wrap; line-height: 1.6;'>
                        {$pengaduan->pesan}
                    </div>
                </div>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . url('/admin/pengaduan') . "' 
                       style='background: linear-gradient(135deg, #2E8B57, #20B2AA); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; display: inline-block; font-weight: bold; box-shadow: 0 4px 15px rgba(46,139,87,0.3);'>
                        🔍 Buka Admin Panel
                    </a>
                </div>
                
                <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 30px; text-align: center;'>
                    <p style='color: #666; font-size: 14px; margin: 0;'>
                        📧 Email otomatis dari <strong>Sistem PUPR Katingan</strong><br>
                        Mohon tidak membalas email ini secara langsung
                    </p>
                </div>
            </div>
        </div>";
    }

    /**
     * Get text email content (fallback)
     */
    private function getEmailTextContent($pengaduan)
    {
        return "
🚨 PENGADUAN BARU - PUPR KATINGAN
===============================

INFORMASI PENGADU:
- Nama: {$pengaduan->nama}
- Email: {$pengaduan->email}
- No. HP: " . ($pengaduan->no_hp ?: '-') . "
- Subjek: {$pengaduan->subjek}
- Waktu: " . now()->format('d F Y, H:i') . " WIB

INTI PENGADUAN:
{$pengaduan->pesan}

===============================
Untuk menanggapi, silakan buka:
" . url('/admin/pengaduan') . "

Email otomatis dari sistem PUPR Katingan
Jangan balas email ini secara langsung.
        ";
    }
}
