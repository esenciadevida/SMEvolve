<?php

namespace App\Mail;

use App\Models\QuoteSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteSubmission $submission) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New quote request');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quotes.new-quote',
            text: 'emails.quotes.plain',
        );
    }
}
