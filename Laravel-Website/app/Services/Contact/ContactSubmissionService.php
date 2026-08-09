<?php

namespace App\Services\Contact;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Support\Facades\Log;

class ContactSubmissionService
{
    public function __construct(
        private readonly AdminNotificationService $notifications,
    ) {}

    /**
     * Handle a validated contact enquiry.
     *
     * Sanitizes the payload, persists it for review in the Admin Portal, and
     * notifies the configured administrators. Email notifications and CRM
     * sync (HubSpot, Zoho, Salesforce, custom) plug in here without changing
     * the form, request, or controller.
     */
    public function submit(array $validated): array
    {
        $payload = $this->sanitize($validated);

        $message = ContactMessage::create([
            'name' => $payload['name'],
            'company' => $payload['company'] ?? null,
            'email' => $payload['email'],
            'phone' => $payload['phone'] ?? null,
            'contact_method' => $payload['contact_method'] ?? null,
            'subject' => $payload['subject'] ?? null,
            'budget' => $payload['budget'] ?? null,
            'message' => $payload['message'],
        ]);

        $this->notifications->notify(
            event: 'business.contact_message',
            subject: 'New contact message',
            messageLines: [sprintf('A new contact message from %s (%s) has been submitted.', $message->name, $message->email)],
            actionUrl: route('admin.contact.show', $message),
            actionText: 'View message',
            mail: new NewContactMessage($message),
        );

        Log::channel('stack')->info('contact.enquiry.received', $payload);

        return $payload;
    }

    /**
     * Keep only known fields and normalize text input before it leaves the app.
     */
    private function sanitize(array $validated): array
    {
        $allowed = ['name', 'company', 'email', 'phone', 'contact_method', 'subject', 'budget', 'message', 'consent'];

        return collect($validated)
            ->only($allowed)
            ->map(fn ($value) => is_string($value) ? trim(strip_tags($value)) : $value)
            ->all();
    }
}
