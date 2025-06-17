<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $hargaUnik;

    public function __construct($user, $hargaUnik)
    {
        $this->user = $user;
        $this->hargaUnik = $hargaUnik;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pendaftaran Event')->view('emails.register');
    }
}
