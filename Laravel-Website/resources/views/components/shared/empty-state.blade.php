@props([
    'icon' => 'inbox',
    'title',
    'description' => null,
])

@php
    $icons = [
        'inbox' => ['M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z'],
    ];
@endphp

<div
    {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-surface px-6 py-16 text-center']) }}
>
    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-600/10">
        <x-icon :name="$icons[$icon] ?? $icons['inbox']" class="h-7 w-7 text-primary-600" />
    </div>

    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $title }}</h3>

    @if ($description)
        <p class="mt-2 max-w-md text-sm leading-relaxed text-gray-500">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-6">{{ $slot }}</div>
    @endif
</div>
