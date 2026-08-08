@props(['id' => 'team'])

@php
    $members = (new \App\Data\AboutData())->team();
    $pillars = (new \App\Data\AboutData())->philosophyPillars();
@endphp

<section id="{{ $id }}" class="bg-white dark:bg-dark" aria-labelledby="{{ $id }}-heading">
    <div class="mx-auto max-w-site px-6 py-16 lg:px-8 lg:py-24">
        <header class="mx-auto max-w-3xl text-center">
            <h3 class="text-sm font-semibold uppercase tracking-widest text-primary-600">How We Work</h3>

            <h2 id="{{ $id }}-heading" class="mt-3 text-balance text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                The People Behind SMEvolve
            </h2>

            <p class="mt-4 text-lg leading-relaxed text-gray-600">
                SMEvolve is built around collaboration, continuous learning, and a genuine commitment to delivering value to every client. Behind every project is a team of people who listen first, communicate openly, and treat your business goals as their own.
            </p>
        </header>

        <div class="mt-12 grid gap-6 text-left sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($members as $member)
                <x-cards.team-card
                    :name="$member['name']"
                    :role="$member['role'] ?? null"
                    :bio="$member['bio'] ?? null"
                    :image="$member['image'] ?? null"
                    :linkedin="$member['linkedin'] ?? null"
                />
            @empty
                @foreach ($pillars as $pillar)
                    <article class="group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                            <x-icon :name="$pillar['icon']" class="h-6 w-6" />
                        </div>

                        <h4 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $pillar['title'] }}</h4>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $pillar['description'] }}</p>

                        @if (filled($pillar['points'] ?? []))
                            <ul class="mt-5 flex-1 space-y-2.5">
                                @foreach ($pillar['points'] as $point)
                                    <li class="flex items-start gap-2.5 text-sm leading-relaxed text-gray-600 dark:text-slate-300">
                                        <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                                        {{ $point }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
