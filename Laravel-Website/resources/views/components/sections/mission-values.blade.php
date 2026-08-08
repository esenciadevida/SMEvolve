@props(['id' => 'mission-vision-values'])

@php
    $values = app(\App\Services\Content\ContentService::class)->values();

    $cards = [
        [
            'label' => 'Our Purpose',
            'title' => 'Mission',
            'icon' => 'target',
            'text' => 'text-primary-600 dark:text-primary-400',
            'statement' => 'To help businesses grow through practical, dependable digital solutions that solve real-world challenges and create lasting value.',
            'body' => "We exist to close the gap between the technology a business needs and the technology it has. Instead of forcing your operations into a generic tool, we shape every solution around the way you actually work, so the software you invest in earns its place every day.",
            'points' => [
                'We understand the real problem before we recommend a solution.',
                'We build reliable, scalable technology that grows with your business.',
                'We measure success by outcomes, efficiency, revenue, and confidence.',
            ],
        ],
        [
            'label' => "Where We're Going",
            'title' => 'Vision',
            'icon' => 'rocket-launch',
            'text' => 'text-secondary-600 dark:text-secondary-400',
            'statement' => 'To become a trusted technology partner for businesses by delivering digital solutions that help you grow, run more efficiently, and succeed over the long term.',
            'body' => 'We believe the strongest partnerships are built on trust, honesty, and results. Our vision is a working relationship in which you see technology as a strategic advantage, not a complication, and where every project we deliver strengthens the foundation for everything that comes next.',
            'points' => [
                'We earn trust through honest recommendations and clear communication.',
                'We help you treat technology as a growth advantage, not a cost.',
                'We build for the long term, so each project sets you up for the next.',
            ],
        ],
    ];
@endphp

<x-sections.section :id="$id" variant="surface" eyebrow="What We Stand For" heading="Our Mission, Vision & Values" description="The principles that shape every project we take on and every partnership we build.">
    <div class="grid gap-12 lg:grid-cols-2 lg:gap-16">
        @foreach ($cards as $card)
            <div>
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                        <x-icon :name="$card['icon']" class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest {{ $card['text'] }}">{{ $card['label'] }}</p>
                        <h3 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">{{ $card['title'] }}</h3>
                    </div>
                </div>

                <blockquote class="mt-6 text-lg font-medium leading-relaxed text-gray-800">
                    {{ $card['statement'] }}
                </blockquote>

                <p class="mt-3 text-base leading-relaxed text-gray-600">
                    {{ $card['body'] }}
                </p>

                <div aria-hidden="true" class="mt-6 h-px w-full bg-gradient-to-r from-gray-200 via-gray-200 to-transparent dark:from-gray-700 dark:via-gray-700 dark:to-transparent"></div>

                <p class="mt-5 text-xs font-semibold uppercase tracking-widest text-gray-500">What it means in practice</p>

                <ul class="mt-3 space-y-2.5">
                    @foreach ($card['points'] as $point)
                        <li class="flex items-start gap-3 text-sm leading-relaxed text-gray-700 dark:text-slate-300">
                            <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                            {{ $point }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="mt-20 flex flex-col items-center">
        <div aria-hidden="true" class="h-1 w-12 rounded-full bg-gradient-to-r from-primary-600 to-accent-500"></div>
        <h3 class="mt-4 text-sm font-semibold uppercase tracking-widest text-primary-600">Core Values</h3>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($values as $value)
            <x-cards.benefit-card
                :title="$value['title']"
                :description="$value['description']"
                :icon="$value['icon']"
            />
        @endforeach
    </div>
</x-sections.section>
