<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QrCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $qrCodePath;

    public function __construct($user, $qrCodePath)
    {
        $this->user = $user;
        $this->qrCodePath = $qrCodePath;
    }

    public function build()
    {
        return $this->subject('QR Code Registrasi')
            ->view('emails.qrcode')
            ->attach(storage_path('app/public/' . $this->qrCodePath), [
                'as' => 'qrcode.png',
                'mime' => 'image/png',
            ]);
    }
}
