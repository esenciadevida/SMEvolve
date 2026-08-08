@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $variants = [
        'success' => ['class' => 'border-success-500/30 bg-success-500/10 text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400', 'icon' => 'check-circle'],
        'error' => ['class' => 'border-error-500/30 bg-error-500/10 text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400', 'icon' => 'exclamation-triangle'],
        'warning' => ['class' => 'border-warning-500/30 bg-warning-500/10 text-warning-700 dark:border-warning-500/30 dark:bg-warning-500/10 dark:text-warning-400', 'icon' => 'exclamation-triangle'],
        'info' => ['class' => 'border-info-500/30 bg-info-500/10 text-info-700 dark:border-info-500/30 dark:bg-info-500/10 dark:text-info-400', 'icon' => 'information-circle'],
    ];

    $variant = $variants[$type] ?? $variants['info'];
@endphp

<div
    x-data="{ visible: true }"
    x-show="visible"
    x-cloak
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    role="alert"
    {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-2xl border p-4 text-sm '.$variant['class']]) }}
>
    <x-icon :name="$variant['icon']" class="mt-0.5 h-5 w-5 flex-none" />

    <div class="min-w-0 flex-1 space-y-1">
        @if ($title)
            <p class="font-semibold">{{ $title }}</p>
        @endif
        <div class="leading-relaxed">{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            @click="visible = false"
            class="flex-none rounded-lg p-1 transition hover:bg-white/40"
            aria-label="Dismiss notification"
            data-track="alert:dismiss"
        >
            <x-icon name="x-mark" class="h-4 w-4" />
        </button>
    @endif
</div>
