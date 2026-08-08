@props([
    'document' => [],
])

<div class="mx-auto w-full max-w-3xl">
    @foreach ($document['sections'] ?? [] as $index => $section)
        @php
            $sectionId = $section['id'] ?? 'section-'.($index + 1);
        @endphp

        <section
            id="{{ $sectionId }}"
            aria-labelledby="{{ $sectionId }}-heading"
            @class([
                'mt-12' => ! $loop->first,
            ])
        >
            <h2 id="{{ $sectionId }}-heading" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                <span class="mr-2 text-primary-600 dark:text-primary-400">{{ $index + 1 }}.</span>{{ $section['heading'] }}
            </h2>

            @if (filled($section['body'] ?? null))
                <p class="mt-3 leading-relaxed text-gray-600 dark:text-slate-300">{{ $section['body'] }}</p>
            @endif

            @if (filled($section['paragraphs'] ?? []))
                @foreach ($section['paragraphs'] as $paragraph)
                    <p class="mt-3 leading-relaxed text-gray-600 dark:text-slate-300">{{ $paragraph }}</p>
                @endforeach
            @endif

            @if (filled($section['bullets'] ?? []))
                <ul class="mt-4 space-y-2">
                    @foreach ($section['bullets'] as $bullet)
                        <li class="flex items-start gap-2.5">
                            <x-icon name="check-circle" class="mt-1 h-4 w-4 flex-none text-primary-600 dark:text-primary-400" />
                            <span class="leading-relaxed text-gray-600 dark:text-slate-300">{{ $bullet }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (filled($section['links'] ?? []))
                <ul class="mt-4 space-y-2">
                    @foreach ($section['links'] as $link)
                        <li>
                            <a
                                href="{{ route($link['route']) }}"
                                class="inline-flex items-center gap-1.5 font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                            >
                                {{ $link['label'] }}
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (filled($section['subsections'] ?? []))
                <div class="mt-5 space-y-5">
                    @foreach ($section['subsections'] as $subsection)
                        <div>
                            <h3 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white">{{ $subsection['heading'] }}</h3>

                            @if (filled($subsection['body'] ?? null))
                                <p class="mt-2 leading-relaxed text-gray-600 dark:text-slate-300">{{ $subsection['body'] }}</p>
                            @endif

                            @if (filled($subsection['bullets'] ?? []))
                                <ul class="mt-3 space-y-2">
                                    @foreach ($subsection['bullets'] as $bullet)
                                        <li class="flex items-start gap-2.5">
                                            <x-icon name="check-circle" class="mt-1 h-4 w-4 flex-none text-primary-600 dark:text-primary-400" />
                                            <span class="leading-relaxed text-gray-600 dark:text-slate-300">{{ $bullet }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
</div>
