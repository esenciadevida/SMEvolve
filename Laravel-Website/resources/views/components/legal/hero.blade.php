@props([
    'document' => [],
    'full' => true,
])

@php
    $visualVariant = match ($document['key'] ?? null) {
        'privacy-policy' => 'legal-privacy',
        'terms' => 'legal-terms',
        'cookies' => 'legal-cookies',
        default => 'legal-privacy',
    };
@endphp

<x-sections.page-hero
    id="legal-{{ $document['key'] ?? 'document' }}"
    eyebrow="Legal"
    :heading="$document['title'] ?? ''"
    :description="$document['hero']['description'] ?? null"
    :variant="$visualVariant"
    :breadcrumb="[['label' => $document['title'] ?? '']]"
    :full="$full"
/>
