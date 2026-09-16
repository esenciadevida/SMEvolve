@props([
    'id' => 'industries',
    'heading' => 'Technology Solutions For Different Industries',
    'description' => 'Every industry has unique challenges. SMEvolve builds digital solutions tailored to the needs of businesses, organisations, and professionals across different sectors.',
    'industries' => null,
])

@php
    $industries = $industries ?? app(\App\Services\Content\ContentService::class)->industries();
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" align="center" background="blobs">
    <div data-reveal-group class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($industries as $industry)
            <x-cards.industry-card
                :title="$industry['title']"
                :description="$industry['description'] ?? null"
                :icon="$industry['icon'] ?? null"
                :solutions="$industry['solutions'] ?? []"
                :url="$industry['url'] ?? null"
            />
        @endforeach
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('contact') }}">Discuss Your Business Needs</x-buttons.secondary-button>
    </div>
</x-sections.section>
