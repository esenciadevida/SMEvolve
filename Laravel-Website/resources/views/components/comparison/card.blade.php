@props([
    'package' => [],
    'features' => [],
    'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
    'recommended' => false,
    'index' => 0,
])

@php
    $ctaHref = isset($cta['route']) ? route($cta['route']) : route('quote');
    $ctaLabel = $cta['label'] ?? 'Request Quote';
    $detailsId = 'comparison-details-'.$index;
    $triggerId = 'comparison-trigger-'.$index;
@endphp

<div
    x-data="{ open: false }"
    class="{{ $recommended ? 'border-primary-600/40 ring-2 ring-primary-600/10' : 'border-gray-200/70' }} flex h-full flex-col rounded-2xl border bg-white shadow-sm dark:bg-dark-card"
>
    <div class="flex items-start justify-between gap-3 px-6 pt-6">
        <div>
            <h3 class="text-lg font-semibold tracking-tight text-gray-900">{{ $package['name'] }}</h3>

            @if (! empty($package['description']))
                <p class="mt-1 text-sm leading-relaxed text-gray-600">{{ $package['description'] }}</p>
            @endif
        </div>

        @if (! empty($package['badge']))
            <span class="flex-none rounded-full bg-gradient-to-r from-primary-600 to-secondary-600 px-3 py-1 text-xs font-bold text-white">{{ $package['badge'] }}</span>
        @endif
    </div>

    <div class="px-6 pt-5">
        <button
            type="button"
            :id="'{{ $triggerId }}'"
            @click="open = !open"
            :aria-expanded="open ? 'true' : 'false'"
            aria-controls="{{ $detailsId }}"
            class="flex w-full items-center justify-between gap-3 rounded-xl bg-surface px-4 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-100"
            data-track="packages:compare:toggle"
            data-track-data="{{ json_encode(['package' => $package['slug'] ?? null]) }}"
        >
            <span>Compare Features</span>
            <span class="flex-none transition duration-200" :class="open ? 'rotate-180' : ''">
                <x-icon name="chevron-down" class="h-4 w-4" />
            </span>
        </button>
    </div>

    <div :id="'{{ $detailsId }}'" x-show="open" x-cloak x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1">
        <ul class="divide-y divide-gray-100 px-6">
            @foreach ($features as $row)
                <li class="flex items-center justify-between gap-4 py-3">
                    <span class="text-sm font-medium text-gray-700">{{ $row['label'] }}</span>
                    <span class="text-right">
                        <x-comparison.value :value="$row['values'][$package['slug'] ?? null] ?? null" />
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-auto px-6 pb-6 pt-6">
        <x-buttons.button
            :href="$ctaHref"
            :variant="$recommended ? 'primary' : 'secondary'"
            class="w-full"
            data-track="packages:compare:cta"
            data-track-data="{{ json_encode(['package' => $package['slug'] ?? null]) }}"
        >
            {{ $ctaLabel }}
        </x-buttons.button>
    </div>
</div>
