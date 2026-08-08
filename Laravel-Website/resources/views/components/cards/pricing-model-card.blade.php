@props([
    'model' => [],
])

@php
    $suitableFor = $model['suitable_for'] ?? [];
    $characteristics = $model['characteristics'] ?? [];
@endphp

<article class="flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover">
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-sm">
            <x-icon :name="$model['icon'] ?? 'tag'" class="h-5 w-5" />
        </span>
        <h3 class="text-base font-semibold tracking-tight text-gray-900">{{ $model['title'] ?? '' }}</h3>
    </div>

    @if (! empty($model['description']))
        <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $model['description'] }}</p>
    @endif

    @if (filled($suitableFor))
        <div class="mt-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Suitable For</p>
            <ul class="mt-2 flex flex-wrap gap-1.5">
                @foreach ($suitableFor as $item)
                    <li class="rounded-lg bg-surface px-2.5 py-1 text-xs font-medium text-gray-600">{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (filled($characteristics))
        <div class="mt-5 flex-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Key Characteristics</p>
            <ul class="mt-2.5 space-y-2">
                @foreach ($characteristics as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</article>
