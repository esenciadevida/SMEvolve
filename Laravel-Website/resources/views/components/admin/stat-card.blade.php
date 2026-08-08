@props(['label', 'value', 'icon' => 'chart-bar', 'tone' => 'primary', 'hint' => null])

@php
    $tones = [
        'primary' => 'bg-primary-500/10 text-primary-600 dark:text-primary-400',
        'success' => 'bg-success-500/10 text-success-600 dark:text-success-400',
        'warning' => 'bg-warning-500/10 text-warning-600 dark:text-warning-400',
        'error' => 'bg-error-500/10 text-error-600 dark:text-error-400',
        'info' => 'bg-info-500/10 text-info-600 dark:text-info-400',
        'secondary' => 'bg-secondary-500/10 text-secondary-600 dark:text-secondary-400',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white p-5 shadow-card dark:border-slate-800 dark:bg-slate-900']) }}>
    <div class="flex items-start justify-between gap-3">
        <span @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl', $tones[$tone] ?? $tones['primary']])>
            <x-icon :name="$icon" class="h-5 w-5" />
        </span>
        @if ($hint)
            <x-admin.badge :tone="$tone" dot>{{ $hint }}</x-admin.badge>
        @endif
    </div>
    <p class="mt-4 text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $value }}</p>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">{{ $label }}</p>
</div>
