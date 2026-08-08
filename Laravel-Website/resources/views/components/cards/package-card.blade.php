@props([
    'package',
    'recommended' => false,
])

@php
    $ctaRoute = $package['cta']['route'] ?? null;
    $ctaHref = $ctaRoute ? route($ctaRoute) : route('quote');
    $ctaLabel = $package['cta']['label'] ?? 'Request Quote';
    $price = $package['starting_price'] ?? null;
    $badge = $package['badge'] ?? null;
    $audience = $package['target_audience'] ?? [];
    $features = $package['features'] ?? [];
@endphp

<article {{ $attributes->class([
    'group relative flex h-full flex-col rounded-2xl border bg-white p-6 shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:shadow-card-hover',
    'border-primary-600/40 ring-2 ring-primary-600/10' => $recommended,
    'border-gray-200/70 hover:border-primary-600/40' => ! $recommended,
]) }}>
    <div class="flex items-start justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-gray-900">{{ $package['name'] }}</h3>

        @if ($badge)
            <span class="flex-none rounded-full bg-gradient-to-r from-primary-600 to-secondary-600 px-3 py-1 text-xs font-bold text-white shadow-sm">{{ $badge }}</span>
        @endif
    </div>

    @if ($price)
        <p class="mt-3 text-2xl font-bold tracking-tight text-gray-900">
            {{ $price }}
            <span class="text-sm font-medium text-gray-500">starting</span>
        </p>
    @endif

    <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $package['description'] }}</p>

    @if (filled($audience))
        <div class="mt-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Ideal For</p>
            <ul class="mt-2 flex flex-wrap gap-1.5">
                @foreach ($audience as $item)
                    <li class="rounded-lg bg-surface px-2.5 py-1 text-xs font-medium text-gray-600">{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (filled($features))
        <div class="mt-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Includes</p>
            <ul class="mt-2.5 space-y-2">
                @foreach ($features as $feature)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                        <span>{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-auto pt-6">
        <x-buttons.primary-button :href="$ctaHref" class="w-full" data-track="packages:package:select" data-track-data="{{ json_encode(['package' => $package['slug'] ?? null]) }}">
            {{ $ctaLabel }}
        </x-buttons.primary-button>
    </div>
</article>
