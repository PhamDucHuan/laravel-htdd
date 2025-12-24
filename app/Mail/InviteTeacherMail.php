<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteTeacherMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url; // Link đăng ký

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lời mời tham gia hệ thống quản trị học tập của chúng tôi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invite',
            with: ['url' => $this->url],
        );
    }
}