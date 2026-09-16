@props([
    'id' => null,
    'heading' => null,
    'description' => null,
    'eyebrow' => null,
    'align' => 'left',
    'variant' => 'white',
    'background' => null,
])

@php
    $variantClasses = [
        'white' => 'bg-white dark:bg-dark',
        'surface' => 'bg-surface',
        'dark' => 'bg-dark',
    ];
    $contentClasses = $align === 'center' ? 'text-center' : 'text-left';
    $headingClasses = $variant === 'dark' ? 'text-white' : 'text-gray-900';
    $descriptionClasses = $variant === 'dark' ? 'text-slate-400' : 'text-gray-600';
    $eyebrowClasses = $variant === 'dark' ? 'text-primary-400' : 'text-primary-600';
@endphp

<section
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes->class(['relative overflow-hidden', $variantClasses[$variant]]) }}
>
    @if ($background)
        <x-sections.background :name="$background" :variant="$variant" />
    @endif

    <div class="relative mx-auto w-full max-w-site px-6 py-16 lg:px-8 lg:py-24">
        @if ($eyebrow || $heading || $description)
            <header data-reveal @class(['max-w-3xl', $align === 'center' ? 'mx-auto text-center' : 'text-left'])>
                @if ($eyebrow)
                    <p class="text-sm font-semibold uppercase tracking-widest {{ $eyebrowClasses }}">{{ $eyebrow }}</p>
                @endif

                @if ($heading)
                    <h2 @class(['text-3xl font-bold tracking-tight text-balance sm:text-4xl', 'mt-3' => $eyebrow, $headingClasses])>{{ $heading }}</h2>
                @endif

                @if ($description)
                    <p class="mt-4 text-lg leading-relaxed {{ $descriptionClasses }}">{{ $description }}</p>
                @endif
            </header>
        @endif

        @if (! $slot->isEmpty())
            <div class="mt-12 {{ $contentClasses }}">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>
