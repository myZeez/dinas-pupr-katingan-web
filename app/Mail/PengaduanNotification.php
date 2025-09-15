<?php

namespace App\Mail;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengaduanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate admin URL safely
        $adminUrl = '';
        if ($this->pengaduan && $this->pengaduan->id) {
            try {
                $adminUrl = route('admin.pengaduan.show', $this->pengaduan->id);
            } catch (\Exception $e) {
                // Fallback to admin dashboard if route fails
                $adminUrl = url('/admin/pengaduan');
            }
        } else {
            // If no ID, redirect to pengaduan list
            $adminUrl = url('/admin/pengaduan');
        }

        return $this->view('emails.pengaduan-notification')
            ->subject('Pengaduan Baru dari ' . $this->pengaduan->nama)
            ->with([
                'pengaduan' => $this->pengaduan,
                'adminUrl' => $adminUrl
            ]);
    }
}
