@props(['result' => []])

@php
    $icons = [
        'service' => 'code',
        'package' => 'shopping-bag',
        'portfolio' => 'photo',
        'faq' => 'lifebuoy',
        'page' => 'document-text',
    ];

    $icon = $result['metadata']['icon'] ?? ($icons[$result['type']] ?? 'magnifying-glass');
@endphp

<a
    href="{{ $result['url'] }}"
    class="group flex items-start gap-3 rounded-xl px-3 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-800/50"
>
    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary-600/10 text-primary-600 dark:text-primary-400">
        <x-icon :name="$icon" class="h-4 w-4" />
    </span>

    <span class="min-w-0 flex-1">
        <span class="block truncate text-sm font-medium text-gray-900 transition group-hover:text-primary-600 dark:text-white dark:group-hover:text-primary-400">{{ $result['title'] }}</span>
        <span class="block truncate text-xs text-gray-500 dark:text-gray-400">{{ $result['subtitle'] }}</span>
    </span>

    @if (! empty($result['metadata']['category']))
        <span class="mt-0.5 shrink-0 rounded-full bg-gray-100 px-2.5 py-0.5 text-[11px] font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400">{{ $result['metadata']['category'] }}</span>
    @endif

    <x-icon name="arrow-up-right" class="mt-1 h-4 w-4 shrink-0 text-gray-300 transition group-hover:text-primary-500 dark:text-gray-600 dark:group-hover:text-primary-400" />
</a>
