@props([
    'title',
    'description' => null,
    'icon' => null,
    'solutions' => [],
    'url' => null,
])

<article {{ $attributes->class('group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 text-left shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover') }}>
    @if ($icon)
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
            <x-icon :name="$icon" class="h-6 w-6" />
        </div>
    @endif

    <h3 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $title }}</h3>

    @if ($description)
        <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $description }}</p>
    @endif

    @if (! empty($solutions))
        <ul class="mt-4 flex flex-wrap gap-2">
            @foreach ($solutions as $solution)
                <li class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-gray-700 transition group-hover:border-gray-300">{{ $solution }}</li>
            @endforeach
        </ul>
    @endif

    @if ($url)
        <a
            href="{{ $url }}"
            class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
        >
            Learn More
            <x-icon name="arrow-right" class="h-4 w-4 transition duration-300 group-hover:translate-x-0.5" />
        </a>
    @endif
</article>
