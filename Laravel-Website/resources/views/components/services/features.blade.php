@props([
    'service' => [],
    'id' => 'key-features',
])

@php
    $features = $service['features'] ?? [];
    $heading = $features['heading'] ?? 'Key Features';
    $description = $features['description'] ?? '';
    $items = $features['items'] ?? [];
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" align="center">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($items as $item)
            <article class="group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 text-left shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                    <x-icon :name="$item['icon'] ?? 'sparkles'" class="h-6 w-6" />
                </div>

                <h3 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $item['title'] }}</h3>

                @if (! empty($item['description']))
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $item['description'] }}</p>
                @endif
            </article>
        @endforeach
    </div>
</x-sections.section>
