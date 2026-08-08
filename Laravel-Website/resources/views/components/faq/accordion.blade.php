@props([
    'question' => '',
    'answer' => '',
    'open' => false,
    'index' => 0,
    'group' => null,
    'questionId' => null,
    'links' => [],
])

@php
    $identifier = $questionId ?? 'q-'.$index;
    $triggerId = 'faq-trigger-'.$identifier;
    $panelId = 'faq-panel-'.$identifier;
@endphp

<div
    class="rounded-2xl border bg-white shadow-sm dark:bg-dark-card transition duration-300"
    :class="open ? 'border-primary-600/40 shadow-card-hover' : 'border-gray-200/70 hover:border-primary-600/30'"
    x-data="{ open: {{ $open ? 'true' : 'false' }} }"
    @if ($group)
        @faq-toggle.window="if ($event.detail.group === '{{ $group }}') open = ($event.detail.id === '{{ $identifier }}')"
        @faq-reset.window="if ($event.detail.group === '{{ $group }}') open = false"
    @endif
>
    <h3>
        <button
            type="button"
            id="{{ $triggerId }}"
            @if ($group)
                @click="$dispatch('faq-toggle', { group: '{{ $group }}', id: '{{ $identifier }}' })"
            @else
                @click="open = !open"
            @endif
            :aria-expanded="open ? 'true' : 'false'"
            aria-controls="{{ $panelId }}"
            class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left"
        >
            <span class="text-base font-semibold tracking-tight text-gray-900">{{ $question }}</span>
            <span
                class="flex h-8 w-8 flex-none items-center justify-center rounded-full transition duration-200"
                :class="open ? 'rotate-180 bg-gradient-to-br from-primary-600 to-secondary-600 text-white' : 'bg-gray-100 text-gray-500'"
            >
                <x-icon name="chevron-down" class="h-5 w-5" />
            </span>
        </button>
    </h3>
    <div :id="'{{ $panelId }}'" role="region" :aria-labelledby="'{{ $triggerId }}'" x-show="open" x-cloak>
        <div class="px-6 pb-6">
            <p class="max-w-3xl text-sm leading-relaxed text-gray-600">{{ $answer }}</p>

            @if (filled($links))
                <ul class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm">
                    @foreach ($links as $link)
                        <li>
                            <a
                                href="{{ route($link['route'] ?? 'home') }}"
                                class="inline-flex items-center gap-1.5 font-semibold text-primary-600 transition hover:text-primary-700"
                            >
                                {{ $link['label'] }}
                                <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
