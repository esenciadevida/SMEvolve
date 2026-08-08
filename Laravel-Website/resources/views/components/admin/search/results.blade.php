@props(['results' => [], 'labels' => []])

<div class="space-y-8">
    @foreach ($results as $type => $items)
        <div>
            <div class="mb-2 flex items-center justify-between">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    {{ $labels[$type] ?? \Illuminate\Support\Str::title($type) }}
                </h2>
                <span class="text-xs text-slate-400 dark:text-slate-500">{{ count($items) }} result(s)</span>
            </div>

            <div class="divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-white shadow-sm dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900">
                @foreach ($items as $result)
                    <x-admin.search.result-item :result="$result" />
                @endforeach
            </div>
        </div>
    @endforeach
</div>
