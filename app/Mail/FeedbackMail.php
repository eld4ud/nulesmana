<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $messageText;

    public function __construct($name, $email, $messageText)
    {
        $this->name = $name;
        $this->email = $email;
        $this->messageText = $messageText;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Saran & Masukan Baru dari Warga NU Pasiraman Lor',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
                <h2>Saran & Masukan Baru dari Warga</h2>
                <p><strong>Nama:</strong> {$this->name}</p>
                <p><strong>Email:</strong> {$this->email}</p>
                <p><strong>Pesan/Saran:</strong></p>
                <p><i>{$this->messageText}</i></p>
            ",
        );
    }
}