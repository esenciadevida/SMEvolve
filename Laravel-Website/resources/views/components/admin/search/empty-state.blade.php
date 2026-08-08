@props(['icon' => 'magnifying-glass', 'title' => 'No results found', 'subtitle' => null])

<div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center dark:border-slate-700 dark:bg-slate-900">
    <span class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
        <x-icon :name="$icon" class="h-6 w-6" />
    </span>
    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h3>
    @if ($subtitle)
        <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</div>
