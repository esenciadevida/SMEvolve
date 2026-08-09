<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecurityAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  list<string>  $messageLines
     * @param  array<int, array{label: string, value: string}>  $details
     */
    public function __construct(
        public string $event,
        public string $subjectLine,
        public array $messageLines = [],
        public ?string $actionUrl = null,
        public ?string $actionText = null,
        public array $details = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.security-alert');
    }
}
