@props([
    'src',
    'alt' => '',
    'wrapperClass' => '',
    'imgClass' => '',
    'loading' => 'lazy',
    'decoding' => 'async',
    'fetchpriority' => 'auto',
    'icon' => null,
])

<div
    {{ $attributes->class('relative overflow-hidden bg-gray-100 '.$wrapperClass) }}
    x-data="{ loaded: false }"
>
    <div x-show="! loaded" class="absolute inset-0 skeleton" aria-hidden="true">
        @if ($icon)
            <div class="flex h-full w-full items-center justify-center">
                <x-icon :name="$icon" class="h-10 w-10 text-gray-300" />
            </div>
        @endif
    </div>

    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        loading="{{ $loading }}"
        decoding="{{ $decoding }}"
        fetchpriority="{{ $fetchpriority }}"
        x-on:load="loaded = true"
        x-on:error="loaded = true"
        class="relative h-full w-full object-cover transition-opacity duration-500 {{ $imgClass }}"
        :class="loaded ? 'opacity-100' : 'opacity-0'"
    />
</div>
