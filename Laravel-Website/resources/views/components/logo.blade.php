@props(['dark' => false, 'size' => 'h-18', 'href' => null])

@php
    $href = $href ?? route('home');
    $lightSource = asset('images/logo-light.png');
    $darkSource = asset('images/logo-dark.png');
@endphp

<a
    href="{{ $href }}"
    class="inline-flex items-center"
    aria-label="SMEvolve, Home"
>
    @if ($dark)
        <img
            src="{{ $darkSource }}"
            alt="SMEvolve"
            class="{{ $size }} w-auto"
            loading="eager"
        />
    @else
        <img
            src="{{ $lightSource }}"
            alt="SMEvolve"
            class="{{ $size }} w-auto"
            loading="eager"
            x-show="! $store.theme.dark"
            x-cloak
        />
        <img
            src="{{ $darkSource }}"
            alt="SMEvolve"
            class="{{ $size }} w-auto"
            loading="eager"
            x-show="$store.theme.dark"
            x-cloak
        />
    @endif
</a>
