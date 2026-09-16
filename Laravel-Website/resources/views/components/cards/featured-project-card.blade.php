@props(['item' => []])

@php
    $image = $item['image'] ?? null;
    $technologies = $item['technologies'] ?? [];
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl bg-dark-card text-white shadow-card transition duration-300 hover:-translate-y-1 hover:shadow-card-hover">
    <div class="relative aspect-video w-full overflow-hidden bg-gradient-to-br from-primary-800 to-secondary-700">
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
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">{{ $item['category'] }}</span>
            <span class="rounded-full bg-white/10 px-2.5 py-0.5 text-[11px] font-semibold text-slate-300">{{ $item['status'] }}</span>
        </div>

        <h3 class="mt-2 text-lg font-semibold tracking-tight text-white">{{ $item['title'] }}</h3>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-400">{{ $item['description'] }}</p>

        @if (! empty($technologies))
            <ul class="mt-4 flex flex-wrap gap-2">
                @foreach ($technologies as $technology)
                    <li class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-slate-300">{{ $technology }}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ $item['url'] }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-400 transition hover:text-primary-300">
            View Project
            <x-icon name="arrow-right" class="h-4 w-4" />
        </a>
    </div>
</article>
