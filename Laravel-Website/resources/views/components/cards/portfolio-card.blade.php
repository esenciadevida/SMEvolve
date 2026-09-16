@props(['item' => []])
@php
    $image = $item['image'] ?? null;
    $technologies = $item['technologies'] ?? [];
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200/70 bg-white shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover">
    <div class="relative aspect-video w-full overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
        @if ($image)
            <x-media.image
                :src="$image"
                :alt="$item['title'].' project screenshot'"
                icon="photo"
                wrapperClass="h-full w-full"
                imgClass="group-hover:scale-105"
            />
        @endif
    </div>

    <div class="flex flex-1 flex-col p-6 text-left">
        <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">{{ $item['category'] }}</span>
        <h3 class="mt-2 text-lg font-semibold tracking-tight text-gray-900">{{ $item['title'] }}</h3>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $item['description'] }}</p>

        @if (! empty($technologies))
            <ul class="mt-4 flex flex-wrap gap-2">
                @foreach ($technologies as $technology)
                    <li class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">{{ $technology }}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ $item['url'] }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
            View Project
            <x-icon name="arrow-right" class="h-4 w-4" />
        </a>
    </div>
</article>
