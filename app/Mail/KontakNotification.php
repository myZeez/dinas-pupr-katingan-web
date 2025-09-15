<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KontakNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $kontakData;

    /**
     * Create a new message instance.
     */
    public function __construct($kontakData)
    {
        $this->kontakData = $kontakData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.kontak-notification')
            ->subject('Pesan Kontak Baru dari ' . $this->kontakData['nama'])
            ->with([
                'kontakData' => $this->kontakData
            ]);
    }
}
