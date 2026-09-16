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
    <div data-process class="relative">
        <svg aria-hidden="true" class="pointer-events-none absolute inset-0 hidden h-full w-full lg:block" viewBox="0 0 1200 420" fill="none" preserveAspectRatio="none">
            <path data-process-path class="dashed-path" d="M-20 70 C 280 20, 320 200, 620 130 S 940 30, 1220 150" stroke="rgb(139 92 246 / 0.5)" stroke-width="1.5" />
        </svg>

        <div class="relative grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($steps as $step)
                <x-cards.process-step-card
                    :step="$step['step'] ?? null"
                    :title="$step['title']"
                    :description="$step['description'] ?? null"
                    :icon="$step['icon'] ?? null"
                />
            @endforeach
        </div>
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Start Your Project</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('contact') }}">Contact Us</x-buttons.secondary-button>
    </div>
</x-sections.section>
