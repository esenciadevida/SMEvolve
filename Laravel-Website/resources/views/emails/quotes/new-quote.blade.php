@php
    $snapshot = $submission->snapshot ?? [];
@endphp

<x-emails::layouts.smevolve
    :title="'New Quote Request'"
    label="Business notification"
    subtitle="A new quote request was submitted on the SMEvolve website."
>
    <p style="margin:0 0 6px;">A new customer has requested a quote. Review the details below and respond promptly.</p>

    <x-emails::components.info-card :rows="[
        ['label' => 'Reference', 'value' => $submission->reference],
        ['label' => 'Customer', 'value' => $submission->contact_name],
        ['label' => 'Company', 'value' => $snapshot['business_name'] ?? 'Not supplied'],
        ['label' => 'Email', 'value' => $submission->contact_email],
        ['label' => 'Phone', 'value' => $submission->contact_phone ?? 'Not supplied'],
        ['label' => 'Service', 'value' => $snapshot['ai']['recommended_service'] ?? $submission->quoteSession?->project_type ?? '—'],
        ['label' => 'Budget', 'value' => $snapshot['budget_range'] ?? '—'],
        ['label' => 'Submitted', 'value' => $submission->submitted_at],
    ]" />

    <x-emails::components.button :url="route('admin.quotes.show', $submission)" text="View Quote" />

    <x-emails::components.alert tone="info" title="Next step">
        Respond to this lead from the Admin Portal to keep the customer moving.
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
