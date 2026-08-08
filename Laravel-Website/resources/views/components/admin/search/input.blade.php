@props([
    'id' => 'admin-search-input',
    'name' => 'q',
    'value' => '',
    'placeholder' => 'Search quotes, administrators, settings...',
    'autofocus' => false,
])

<div {{ $attributes->merge(['class' => 'relative flex-1']) }}>
    <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" />
    <input
        id="{{ $id }}"
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if ($autofocus) autofocus @endif
        class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
    >
</div>
