@props([
    'icon' => 'magnifying-glass',
    'title' => '',
    'subtitle' => '',
])

<div class="mx-auto max-w-xl rounded-3xl border border-gray-200 bg-white px-6 py-14 text-center shadow-sm dark:border-gray-700 dark:bg-dark-card">
    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-600/10">
        <x-icon :name="$icon" class="h-6 w-6 text-primary-600" />
    </span>

    <h3 class="mt-5 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h3>

    @if ($subtitle)
        <p class="mt-2 text-base leading-relaxed text-gray-600 dark:text-gray-400">{{ $subtitle }}</p>
    @endif
</div>
