@props([
    'id' => 'services',
    'heading' => 'Digital Solutions Built Around Your Business Needs',
    'description' => 'From professional websites to custom software and automation solutions, SMEvolve helps businesses use technology to improve operations, reach customers, and grow.',
    'services' => null,
])

@php
    $services = $services ?? app(\App\Services\Content\ContentService::class)->services();
    $services = collect($services)->where('homepage', true)->values()->all();
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" align="center">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($services as $service)
            <x-cards.service-card
                :title="$service['name']"
                :description="$service['description'] ?? null"
                :icon="$service['icon'] ?? null"
                :url="route('services.show', $service['slug'])"
            />
        @endforeach
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('services.index') }}">View All Services</x-buttons.secondary-button>
    </div>
</x-sections.section>
