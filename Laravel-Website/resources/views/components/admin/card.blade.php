@props(['title' => null, 'subtitle' => null, 'padding' => true])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white shadow-card dark:border-slate-800 dark:bg-slate-900']) }}>
    @if ($title)
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div @class(['p-5' => $padding])>
        {{ $slot }}
    </div>
</div>
