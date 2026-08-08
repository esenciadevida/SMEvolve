@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100 sm:text-2xl">{{ $title }}</h1>
    @if ($subtitle)
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
    @endif
</div>
