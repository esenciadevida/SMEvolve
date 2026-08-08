@props(['tone' => 'slate', 'dot' => false])

@php
    $tones = [
        'slate' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
        'primary' => 'bg-primary-500/10 text-primary-700 dark:text-primary-400',
        'success' => 'bg-success-500/10 text-success-700 dark:text-success-400',
        'warning' => 'bg-warning-500/10 text-warning-700 dark:text-warning-400',
        'error' => 'bg-error-500/10 text-error-700 dark:text-error-400',
        'info' => 'bg-info-500/10 text-info-700 dark:text-info-400',
        'secondary' => 'bg-secondary-500/10 text-secondary-700 dark:text-secondary-400',
    ];

    $dots = [
        'slate' => 'bg-slate-400',
        'primary' => 'bg-primary-500',
        'success' => 'bg-success-500',
        'warning' => 'bg-warning-500',
        'error' => 'bg-error-500',
        'info' => 'bg-info-500',
        'secondary' => 'bg-secondary-500',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ' . ($tones[$tone] ?? $tones['slate'])]) }}>
    @if ($dot)
        <span @class(['h-1.5 w-1.5 rounded-full', $dots[$tone] ?? $dots['slate']])></span>
    @endif
    {{ $slot }}
</span>
