@props([
    'data' => [],
    'valueKey' => 'value',
    'height' => '10rem',
    'color' => 'bg-primary-500',
    'empty' => 'No data yet.',
])

@php
    $values = array_column($data, $valueKey);
    $max = (int) (max(array_merge([0], $values)) ?: 0);
    $hasData = $max > 0;
@endphp

<div {{ $attributes->merge(['class' => 'flex items-end gap-1.5']) }} style="height: {{ $height }};">
    @if ($hasData)
        @foreach ($data as $point)
            @php
                $pct = (int) round((($point[$valueKey] ?? 0) / $max) * 100);
            @endphp
            <div class="group relative flex h-full min-w-0 flex-1 items-end">
                <div
                    class="w-full rounded-t-md {{ $color }} transition-opacity duration-300 group-hover:opacity-80"
                    style="height: {{ max($pct, 4) }}%;"
                    title="{{ $point['full'] ?? $point['label'] }}: {{ $point[$valueKey] }}"
                ></div>
                <div class="pointer-events-none invisible absolute inset-x-0 -top-9 flex flex-col items-center opacity-0 transition-opacity group-hover:visible group-hover:opacity-100">
                    <span class="whitespace-nowrap rounded-md bg-slate-900 px-2 py-1 text-xs font-medium text-white shadow-lg dark:bg-white dark:text-slate-900">{{ $point[$valueKey] }}</span>
                </div>
            </div>
        @endforeach
    @else
        <p class="w-full py-10 text-center text-sm text-slate-400 dark:text-slate-500">{{ $empty }}</p>
    @endif
</div>

@if ($hasData)
    <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">
        <span>{{ $data[0]['label'] ?? '' }}</span>
        <span>{{ $data[count($data) - 1]['label'] ?? '' }}</span>
    </div>
@endif
