@props([
    'icon' => 'chat-bubble-left-right',
    'title',
    'value' => null,
    'description' => null,
    'href' => null,
    'actionLabel' => null,
    'external' => false,
    'track' => null,
    'trackData' => [],
    'socials' => [],
])

<div class="flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-0.5 hover:border-primary-600/30 hover:shadow-card-hover">
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-sm">
            <x-icon :name="$icon" class="h-5 w-5" />
        </span>
        <h3 class="text-base font-semibold tracking-tight text-gray-900">{{ $title }}</h3>
    </div>

    @if ($value)
        <p class="mt-4 break-words text-sm font-medium text-gray-700">{{ $value }}</p>
    @endif

    @if ($description)
        <p class="mt-1 text-sm leading-relaxed text-gray-500">{{ $description }}</p>
    @endif

    @if (! empty($socials))
        <div class="mt-4 flex items-center gap-2">
            @foreach ($socials as $social)
                <a
                    href="{{ $social['href'] }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-primary-600 hover:text-white dark:bg-slate-800 dark:text-slate-300"
                    aria-label="{{ $social['label'] }}"
                    data-track="contact:social"
                    data-track-data="{{ json_encode(['platform' => $social['platform'] ?? null]) }}"
                >
                    <x-icon :name="$social['platform']" class="h-4 w-4" />
                </a>
            @endforeach
        </div>
    @endif

    @if ($href)
        <div class="mt-auto pt-5">
            <a
                href="{{ $href }}"
                @if ($external) target="_blank" rel="noopener" @endif
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                @if ($track) data-track="{{ $track }}" data-track-data="{{ json_encode($trackData) }}" @endif
            >
                {{ $actionLabel ?? $title }}
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    @endif
</div>
