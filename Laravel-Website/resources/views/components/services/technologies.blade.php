@props([
    'service' => [],
    'id' => 'technologies',
])

@php
    $technologies = $service['technologies'] ?? [];
    $heading = $technologies['heading'] ?? 'Technologies We Use';
    $description = $technologies['description'] ?? '';
    $items = $technologies['items'] ?? [];
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="surface" align="center">
    <div class="flex flex-wrap justify-center gap-3">
        @foreach ($items as $technology)
            <span class="rounded-full border border-gray-200 bg-white px-5 py-2.5 dark:border-gray-600 dark:bg-dark-card text-sm font-medium text-gray-700 shadow-sm transition duration-300 hover:border-primary-600/40 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                {{ $technology }}
            </span>
        @endforeach
    </div>
</x-sections.section>
