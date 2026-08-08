@props([
    'title',
    'description' => null,
    'icon' => null,
    'dark' => false,
])

@php
    $cardClasses = $dark
        ? 'border-white/10 bg-white/5 hover:border-white/25'
        : 'border-gray-200/70 bg-white shadow-sm dark:bg-dark-card hover:border-primary-600/40 hover:shadow-card-hover';
    $iconClasses = $dark
        ? 'bg-gradient-to-br from-white/20 to-white/5 text-white ring-1 ring-inset ring-white/20'
        : 'bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20';
    $titleClasses = $dark ? 'text-white' : 'text-gray-900';
    $descriptionClasses = $dark ? 'text-slate-300' : 'text-gray-600';
@endphp

<article {{ $attributes->class('group flex h-full flex-col rounded-2xl p-6 text-left transition duration-300 hover:-translate-y-1 '.$cardClasses) }}>
    @if ($icon)
        <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $iconClasses }}">
            <x-icon :name="$icon" class="h-6 w-6" />
        </div>
    @endif

    <h3 class="mt-5 text-lg font-semibold tracking-tight {{ $titleClasses }}">{{ $title }}</h3>

    @if ($description)
        <p class="mt-2 flex-1 text-sm leading-relaxed {{ $descriptionClasses }}">{{ $description }}</p>
    @endif
</article>
