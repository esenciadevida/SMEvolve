@props(['results' => [], 'labels' => []])

<div class="space-y-8">
    @foreach ($results as $type => $items)
        <div>
            <div class="mb-2 flex items-center justify-between">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    {{ $labels[$type] ?? \Illuminate\Support\Str::title($type) }}
                </h2>
                <span class="text-xs text-gray-400 dark:text-gray-500">{{ count($items) }} result(s)</span>
            </div>

            <div class="divide-y divide-gray-100 rounded-2xl border border-gray-200 bg-white shadow-sm dark:divide-gray-800 dark:border-gray-700 dark:bg-dark-card">
                @foreach ($items as $result)
                    <x-search.result-item :result="$result" />
                @endforeach
            </div>
        </div>
    @endforeach
</div>
