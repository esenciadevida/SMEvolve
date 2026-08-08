@props(['data' => [], 'size' => 168, 'empty' => 'No data yet.'])

@php
    $total = (int) (array_sum(array_column($data, 'value')) ?: 0);
    $colors = [
        'primary' => '#2563eb',
        'success' => '#22c55e',
        'warning' => '#f59e0b',
        'error' => '#ef4444',
        'info' => '#0ea5e9',
        'secondary' => '#6366f1',
    ];
    $radius = 42;
    $circumference = 2 * pi() * $radius;
    $offset = 0;
    $segments = [];

    foreach ($data as $item) {
        $length = $total > 0 ? (($item['value'] ?? 0) / $total) * $circumference : 0;
        $color = $colors[$item['color'] ?? 'primary'] ?? '#2563eb';
        $segments[] = [
            'label' => $item['label'] ?? '',
            'value' => (int) ($item['value'] ?? 0),
            'color' => $color,
            'gap' => $circumference - $length,
            'offset' => -$offset,
        ];
        $offset += $length;
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-6']) }}>
    @if ($total > 0 && count($segments) > 0)
        <svg viewBox="0 0 100 100" width="{{ $size }}" height="{{ $size }}" class="shrink-0 -rotate-90" role="img" aria-label="Donut chart">
            <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="12" class="text-slate-100 dark:text-slate-800" />
            @foreach ($segments as $segment)
                <circle
                    cx="50"
                    cy="50"
                    r="{{ $radius }}"
                    fill="none"
                    stroke="{{ $segment['color'] }}"
                    stroke-width="12"
                    stroke-dasharray="{{ $segment['gap'] }} {{ $segment['gap'] }}"
                    stroke-dashoffset="{{ $segment['offset'] }}"
                >
                    <title>{{ $segment['label'] }}: {{ $segment['value'] }}</title>
                </circle>
            @endforeach
        </svg>

        <div class="min-w-0 flex-1 space-y-2.5">
            @foreach ($segments as $segment)
                <div class="flex items-center justify-between gap-3">
                    <span class="flex min-w-0 items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: {{ $segment['color'] }}"></span>
                        <span class="truncate">{{ $segment['label'] }}</span>
                    </span>
                    <span class="shrink-0 text-sm font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $segment['value'] }}</span>
                </div>
            @endforeach
        </div>
    @else
        <p class="w-full py-10 text-center text-sm text-slate-400 dark:text-slate-500">{{ $empty }}</p>
    @endif
</div>
