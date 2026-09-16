<x-layouts.app
    :title="$project['meta']['title'] ?? $project['title']"
    :description="$project['meta']['description'] ?? $project['summary']"
    :canonical="route('portfolio.show', $project['slug'])"
>
    <x-slot name="structuredData">
        @php
            $structured = [
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $project['title'],
                'description' => $project['meta']['description'] ?? $project['summary'],
                'url' => route('portfolio.show', $project['slug']),
                'author' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'url' => config('app.url'),
                ],
            ];
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structured) !!}
        </script>
    </x-slot>

    <x-sections.project-hero :project="$project" />

    <x-sections.section id="project-overview" heading="Project Overview" :description="$project['summary']">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="space-y-4 text-base leading-relaxed text-gray-600">
                    <p>{{ $project['overview'] ?? $project['summary'] }}</p>
                    @if (filled($project['overviewSecondary'] ?? null))
                        <p>{{ $project['overviewSecondary'] }}</p>
                    @endif
                </div>
            </div>

            <aside class="rounded-2xl border border-gray-200/70 bg-surface p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Project Details</h3>
                <dl class="mt-4 space-y-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Category</dt>
                        <dd class="mt-0.5 font-semibold text-gray-900">{{ $project['category'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Industry</dt>
                        <dd class="mt-0.5 font-semibold text-gray-900">{{ $project['industry'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd class="mt-0.5 font-semibold text-gray-900">{{ $project['status'] }}</dd>
                    </div>
                    @if (filled($relatedServices))
                        <div>
                            <dt class="text-gray-500">Services Involved</dt>
                            <dd class="mt-1.5 space-y-1.5">
                                @foreach ($relatedServices as $service)
                                    <a href="{{ route('services.show', $service['slug']) }}" class="block rounded-full bg-white px-3 py-1.5 text-center font-semibold text-primary-600 ring-1 ring-gray-200 dark:bg-dark-card dark:ring-gray-600 transition hover:bg-primary-50 dark:hover:bg-primary-600/15 hover:ring-primary-600/40">
                                        {{ $service['name'] }}
                                    </a>
                                @endforeach
                            </dd>
                        </div>
                    @endif
                </dl>
            </aside>
        </div>
    </x-sections.section>

    @if (filled($project['gallery']))
        <x-sections.section id="project-gallery" heading="Project Gallery" description="An overview of the project in progress." variant="surface">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($project['gallery'] as $index => $item)
                    <figure class="overflow-hidden rounded-2xl border border-gray-200/70 bg-white shadow-sm dark:bg-dark-card">
                        <div class="relative aspect-[4/3] w-full overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                            @if ($item['image'])
                                <x-media.image :src="$item['image']" :alt="$item['label'].', '.$project['title']" wrapperClass="h-full w-full" imgClass="h-full w-full object-cover" />
                            @endif
                        </div>
                        <figcaption class="p-4">
                            <p class="text-sm font-semibold text-gray-900">{{ $item['label'] }}</p>
                            @if (filled($item['type'] ?? null))
                                <p class="mt-0.5 text-xs leading-relaxed text-gray-500">{{ $item['type'] }}</p>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </x-sections.section>
    @endif

    @if (filled($project['challenge']))
        <x-sections.section id="project-challenge" heading="{{ $project['challenge']['heading'] }}" :description="$project['challenge']['description']">
            <ul class="grid gap-4 sm:grid-cols-2">
                @foreach ($project['challenge']['points'] as $point)
                    <li class="flex items-start gap-3 rounded-2xl border border-gray-200/70 bg-surface p-5">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full bg-error-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-error-500" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <p class="text-sm font-medium leading-relaxed text-gray-700">{{ $point }}</p>
                    </li>
                @endforeach
            </ul>
        </x-sections.section>
    @endif

    @if (filled($project['solution']))
        <x-sections.section id="project-solution" heading="{{ $project['solution']['heading'] }}" :description="$project['solution']['description']" variant="dark">
            <ul class="grid gap-4 sm:grid-cols-2">
                @foreach ($project['solution']['points'] as $point)
                    <li class="flex items-start gap-3 rounded-2xl bg-white/5 p-5 ring-1 ring-inset ring-white/10">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full bg-accent-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-accent-500" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <p class="text-sm font-medium leading-relaxed text-slate-300">{{ $point }}</p>
                    </li>
                @endforeach
            </ul>
        </x-sections.section>
    @endif

    @if (filled($project['features']))
        <x-sections.section id="project-features" heading="Key Features" description="The pieces that come together to make this project work.">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($project['features'] as $feature)
                    <div class="rounded-2xl border border-gray-200/70 bg-surface p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                            <x-icon :name="$feature['icon'] ?? 'code'" class="h-5 w-5" />
                        </span>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-sections.section>
    @endif

    @if (filled($project['technologies']))
        <x-sections.section id="project-technologies" heading="Technologies Used" description="The stack behind this project." variant="surface">
            <ul class="flex flex-wrap justify-center gap-3">
                @foreach ($project['technologies'] as $technology)
                    <li class="rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 dark:bg-dark-card dark:ring-gray-600">{{ $technology }}</li>
                @endforeach
            </ul>
        </x-sections.section>
    @endif

    @if (filled($project['outcome']))
        <x-sections.section id="project-outcome" heading="{{ $project['outcome']['heading'] }}" :description="$project['outcome']['description']">
            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($project['outcome']['points'] as $point)
                    <li class="flex items-start gap-3 rounded-2xl border border-gray-200/70 bg-surface p-5">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full bg-accent-500/10">
                            <x-icon name="trending-up" class="h-4 w-4 text-accent-500" />
                        </span>
                        <p class="text-sm font-medium leading-relaxed text-gray-700">{{ $point }}</p>
                    </li>
                @endforeach
            </ul>
        </x-sections.section>
    @endif

    @if ($prevProject || $nextProject)
        <section class="bg-white dark:bg-dark" aria-label="More portfolio projects">
            <div class="mx-auto w-full max-w-site px-6 py-12 lg:px-8">
                <nav class="grid gap-4 sm:grid-cols-2">
                    @if ($prevProject)
                        <a href="{{ route('portfolio.show', $prevProject['slug']) }}" class="group flex items-center gap-4 rounded-2xl border border-gray-200/70 bg-surface p-5 transition hover:border-primary-600/40 hover:shadow-card-hover">
                            <x-icon name="arrow-right" class="h-5 w-5 flex-none rotate-180 text-gray-400 transition group-hover:text-primary-600" />
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Previous Project</span>
                                <span class="mt-0.5 block font-semibold text-gray-900">{{ $prevProject['title'] }}</span>
                            </span>
                        </a>
                    @else
                        <span aria-hidden="true"></span>
                    @endif

                    @if ($nextProject)
                        <a href="{{ route('portfolio.show', $nextProject['slug']) }}" class="group flex items-center justify-end gap-4 rounded-2xl border border-gray-200/70 bg-surface p-5 text-right transition hover:border-primary-600/40 hover:shadow-card-hover">
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Next Project</span>
                                <span class="mt-0.5 block font-semibold text-gray-900">{{ $nextProject['title'] }}</span>
                            </span>
                            <x-icon name="arrow-right" class="h-5 w-5 flex-none text-gray-400 transition group-hover:text-primary-600" />
                        </a>
                    @endif
                </nav>
            </div>
        </section>
    @endif

    @if (filled($relatedProjects))
        <x-sections.section id="related-projects" heading="Related Projects" description="Explore more work from our portfolio." variant="surface">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($relatedProjects as $related)
                    <x-cards.portfolio-card :item="$related" />
                @endforeach
            </div>
        </x-sections.section>
    @endif

    <x-sections.final-cta
        heading="Let's Build Your Next Digital Solution"
        description="Tell us about your project. We'll listen, ask the right questions, and recommend the approach that fits your business, no pressure, no obligation."
    />
</x-layouts.app>
