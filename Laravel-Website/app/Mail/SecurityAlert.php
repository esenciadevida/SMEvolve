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

    /** Eyebrow label shown above the email heading. */
    public string $label;

    /** Event-specific security guidance. */
    public string $note;

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
        ?string $note = null,
    ) {
        $this->label = $this->labelFor($event);
        $this->note = $note ?? $this->noteFor($event);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(
            view: $this->viewFor($this->event),
            text: 'emails.security.plain',
        );
    }

    private function viewFor(string $event): string
    {
        return match ($event) {
            'security.login_success' => 'emails.security.login-success',
            'security.login_failed' => 'emails.security.login-failed',
            'security.password_changed' => 'emails.security.password-changed',
            'security.password_reset' => 'emails.security.password-reset',
            'administrators.created' => 'emails.security.administrator-created',
            'administrators.disabled' => 'emails.security.administrator-disabled',
            'administrators.role_changed' => 'emails.security.role-changed',
            default => 'emails.security.generic',
        };
    }

    private function labelFor(string $event): string
    {
        return match ($event) {
            'security.login_failed' => 'Security alert',
            'security.password_reset' => 'Password reset',
            'administrators.created', 'administrators.disabled', 'administrators.role_changed' => 'Account activity',
            default => 'Security notification',
        };
    }

    private function noteFor(string $event): string
    {
        return match ($event) {
            'security.login_success' => 'If you recognize this activity, no action is required. If you do not recognize this activity, review your administrator account immediately.',
            'security.login_failed' => 'If this was not you, someone may be attempting to access your administrator account. Contact a Super Administrator if these attempts continue.',
            'security.password_changed' => 'If you did not make this change, secure your account immediately.',
            'security.password_reset' => 'If you did not request a password reset, contact a Super Administrator immediately.',
            'administrators.created' => 'If you were not expecting a new administrator account, contact a Super Administrator immediately.',
            'administrators.disabled' => 'If you were not expecting this change, contact a Super Administrator immediately.',
            'administrators.role_changed' => 'If you were not expecting this change, contact a Super Administrator immediately.',
            default => 'If you believe this event was unexpected, contact a Super Administrator immediately.',
        };
    }
}
