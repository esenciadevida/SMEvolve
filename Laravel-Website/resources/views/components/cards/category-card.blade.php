@props([
    'category' => [],
    'url' => null,
])

@php
    $name = $category['name'] ?? '';
    $count = $category['projectCount'] ?? 0;
    $description = $category['description'] ?? '';
    $icon = $category['icon'] ?? 'code';
    $url = $url ?? route('portfolio.category', $category['slug']);
@endphp

<a href="{{ $url }}" class="group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover">
    <div class="flex items-center justify-between">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
            <x-icon :name="$icon" class="h-6 w-6" />
        </span>
        <span class="rounded-full bg-surface px-3 py-1 text-xs font-semibold text-gray-600">
            {{ $count }} {{ Str::plural('Project', $count) }}
        </span>
    </div>

    <h3 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $name }}</h3>
    <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $description }}</p>

    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition group-hover:gap-2.5">
        Explore Projects
        <x-icon name="arrow-right" class="h-4 w-4" />
    </span>
</a>
