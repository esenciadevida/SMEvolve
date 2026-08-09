<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SystemNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  list<string>  $messageLines
     * @param  array<int, array{label: string, value: string}>  $details
     */
    public function __construct(
        public string $subjectLine,
        public string $summary,
        public array $messageLines = [],
        public array $details = [],
        public ?string $actionUrl = null,
        public ?string $actionText = null,
        public ?string $note = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system.system-notice',
            text: 'emails.system.plain',
        );
    }
}
