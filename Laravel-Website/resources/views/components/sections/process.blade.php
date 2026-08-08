@props([
    'id' => 'development-process',
    'heading' => 'Our Development Process',
    'description' => 'Every successful project starts with understanding your business. Our structured process keeps you informed from the first conversation through launch and ongoing support.',
    'steps' => null,
])

@php
    $steps = $steps ?? config('process');
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="surface" align="center">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($steps as $step)
            <x-cards.process-step-card
                :step="$step['step'] ?? null"
                :title="$step['title']"
                :description="$step['description'] ?? null"
                :icon="$step['icon'] ?? null"
            />
        @endforeach
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Start Your Project</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('contact') }}">Contact Us</x-buttons.secondary-button>
    </div>
</x-sections.section>
