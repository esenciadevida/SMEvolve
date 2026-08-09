@php
    $snapshot = $submission->snapshot ?? [];
@endphp
New Quote Request

A new quote request was submitted on the SMEvolve website.

Reference: {{ $submission->reference }}
Customer: {{ $submission->contact_name }}
Company: {{ $snapshot['business_name'] ?? 'Not supplied' }}
Email: {{ $submission->contact_email }}
Phone: {{ $submission->contact_phone ?? 'Not supplied' }}
Service: {{ $snapshot['ai']['recommended_service'] ?? $submission->quoteSession?->project_type ?? '—' }}
Budget: {{ $snapshot['budget_range'] ?? '—' }}
Submitted: {{ \App\Support\EmailFormat::format($submission->submitted_at) }}

View Quote:
{{ route('admin.quotes.show', $submission) }}

This is an automated notification from SMEvolve.

Copyright (c) {{ date('Y') }} SMEvolve. All rights reserved.
smevolve.tech
