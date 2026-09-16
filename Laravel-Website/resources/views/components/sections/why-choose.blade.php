@props([
    'id' => 'why-choose',
    'heading' => 'Why Businesses Choose SMEvolve',
    'description' => 'Technology projects succeed when they solve real business problems. SMEvolve combines technical expertise with business understanding to create solutions that are practical, scalable, and built for growth.',
    'benefits' => null,
    'variant' => 'dark',
])

@php
    $benefits = $benefits ?? app(\App\Services\Content\ContentService::class)->benefits();
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" :variant="$variant" align="center" background="mesh">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($benefits as $benefit)
            <x-cards.benefit-card
                :title="$benefit['title']"
                :description="$benefit['description'] ?? null"
                :icon="$benefit['icon'] ?? null"
                :dark="$variant === 'dark'"
            />
        @endforeach
    </div>
</x-sections.section>
