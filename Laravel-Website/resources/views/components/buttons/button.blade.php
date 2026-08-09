@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'display' => null,
])

@php
    $variantClasses = [
        'primary' => 'bg-gradient-to-r from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/25 hover:from-primary-700 hover:to-secondary-700 hover:shadow-xl hover:shadow-primary-600/35 focus-visible:ring-primary-600',
        'secondary' => 'border border-gray-300 bg-white text-gray-900 shadow-sm hover:border-gray-400 hover:bg-gray-50 focus-visible:ring-gray-400 dark:border-gray-600 dark:bg-dark-card dark:hover:bg-gray-800',
        'white' => 'bg-white text-primary-700 shadow-lg shadow-black/10 hover:bg-primary-50 focus-visible:ring-white',
        'outline-white' => 'border border-white/40 text-white hover:border-white/70 hover:bg-white/10 focus-visible:ring-white',
    ];

    $displayClass = $display ? trim($display).' ' : 'inline-flex ';

    $classes = trim(
        $displayClass.'items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold transition duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 '
        .$variantClasses[$variant]
    );
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
