<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidateName;
    public $secureUrl;

    // استقبال اسم الموظف والرابط الآمن عند استدعاء الإيميل
    public function __construct($candidateName, $secureUrl)
    {
        $this->candidateName = $candidateName;
        $this->secureUrl = $secureUrl;
    }

    // عنوان الإيميل الذي سيظهر للموظف في صندوق الوارد
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dein Arbeitsvertrag ist bereit zum Unterschreiben ✍️',
        );
    }

    // ربط الإيميل بقالب التصميم
    public function content(): Content
    {
        return new Content(
            view: 'emails.contract_ready',
        );
    }
}
