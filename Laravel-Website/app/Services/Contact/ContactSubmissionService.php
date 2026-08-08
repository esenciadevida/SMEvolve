<?php

namespace App\Services\Contact;

use Illuminate\Support\Facades\Log;

class ContactSubmissionService
{
    /**
     * Handle a validated contact enquiry.
     *
     * Sanitizes the payload and hands it to the submission pipeline.
     * Email notifications and CRM sync (HubSpot, Zoho, Salesforce, custom)
     * plug in here without changing the form, request, or controller.
     */
    public function submit(array $validated): array
    {
        $payload = $this->sanitize($validated);

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
