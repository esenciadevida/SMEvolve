@props([
    'service' => [],
    'id' => 'our-solution',
])

@php
    $solution = $service['solution'] ?? [];
    $heading = $solution['heading'] ?? 'Our Solution';
    $description = $solution['description'] ?? '';
    $points = $solution['points'] ?? [];
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="surface" align="center">
    <div class="mx-auto max-w-3xl space-y-4 text-left">
        @foreach ($points as $point)
            <div class="flex items-start gap-4 rounded-2xl border border-gray-200/70 bg-white p-5 shadow-sm dark:bg-dark-card">
                <span class="mt-0.5 flex h-7 w-7 flex-none items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                </span>
                <p class="text-lg font-medium leading-relaxed text-gray-800">{{ $point }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('contact') }}">Contact Us</x-buttons.secondary-button>
    </div>
</x-sections.section>
