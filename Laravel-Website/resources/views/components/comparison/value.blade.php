@props([
    'value' => null,
])

@php
    if ($value === true) {
        $kind = 'check';
    } elseif ($value === false) {
        $kind = 'none';
    } elseif ($value === 'optional') {
        $kind = 'optional';
    } else {
        $kind = 'text';
    }
@endphp

@if ($kind === 'check')
    <span class="inline-flex items-center justify-center text-accent-500" role="img" aria-label="Included">
        <x-icon name="check-circle" class="h-5 w-5" />
    </span>
@elseif ($kind === 'none')
    <span class="inline-flex items-center justify-center font-semibold text-gray-300" role="img" aria-label="Not included">-</span>
@elseif ($kind === 'optional')
    <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">Optional</span>
@else
    <span class="text-sm leading-snug text-gray-700">{{ $value }}</span>
@endif
