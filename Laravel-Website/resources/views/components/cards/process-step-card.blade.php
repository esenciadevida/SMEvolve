@props([
    'step',
    'title',
    'description' => null,
    'icon' => null,
])

<article {{ $attributes->class('group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 text-left shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover') }}>
    <div class="flex items-center justify-between">
        @if ($icon)
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                <x-icon :name="$icon" class="h-6 w-6" />
            </div>
        @endif

        @if ($step)
            <span class="text-4xl font-extrabold tracking-tight text-gray-100 transition duration-300 group-hover:text-primary-200" aria-hidden="true">{{ str_pad((string) $step, 2, '0', STR_PAD_LEFT) }}</span>
        @endif
    </div>

    <h3 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $title }}</h3>

    @if ($description)
        <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $description }}</p>
    @endif
</article>
