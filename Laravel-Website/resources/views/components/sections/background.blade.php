@props([
    'name' => null,
    'variant' => 'white',
])

@php
    $isDark = $variant === 'dark';
    $grid = $isDark ? 'bg-grid-dark' : 'bg-grid-light';
    $dots = $isDark ? 'bg-dot-grid-dark' : 'bg-dot-grid-light';
@endphp

@if ($name === 'grid-glow')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 {{ $grid }} mask-fade-edges opacity-70"></div>
        <div class="absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-primary-500/15 blur-3xl"></div>
    </div>
@elseif ($name === 'mesh')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-mesh opacity-80"></div>
    </div>
@elseif ($name === 'blobs')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-secondary-500/15 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 h-80 w-80 rounded-full bg-primary-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-accent-500/10 blur-3xl"></div>
    </div>
@elseif ($name === 'dots')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 {{ $dots }} mask-fade-edges opacity-70"></div>
    </div>
@elseif ($name === 'contours')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <svg class="absolute -right-24 -top-24 h-[38rem] w-[38rem] opacity-[0.18]" viewBox="0 0 600 600" fill="none">
            @for ($i = 1; $i <= 8; $i++)
                <ellipse cx="300" cy="300" rx="{{ 40 + $i * 34 }}" ry="{{ 26 + $i * 24 }}" stroke="currentColor" stroke-width="1" class="{{ $isDark ? 'text-white' : 'text-slate-900' }}" />
            @endfor
        </svg>
    </div>
@elseif ($name === 'aurora')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-aurora opacity-60"></div>
        <div class="absolute inset-0 bg-dark/40"></div>
    </div>
@endif
