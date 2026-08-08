<x-layouts.app
    :title="config('portfolio.meta.title', 'Portfolio')"
    :description="config('portfolio.meta.description', 'Explore examples of the work we plan and deliver.')"
    :canonical="route('portfolio')"
>
    <x-slot name="structuredData">
        @php
            $structured = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => 'SMEvolve Portfolio',
                'itemListElement' => $projects->values()->map(fn ($project, $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => route('portfolio.show', $project['slug']),
                    'name' => $project['title'],
                ])->all(),
            ];
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structured) !!}
        </script>
    </x-slot>

    <x-sections.portfolio-hero
        eyebrow="Our Work"
        heading="Portfolio"
        :description="config('portfolio.meta.description')"
        :breadcrumb="[['label' => 'Portfolio']]"
        :projects="$featured"
        badge="{{ $categories->count() }} Areas of Expertise"
    >
        <x-buttons.button variant="white" href="{{ route('quote') }}">
            Get a Free Quote
        </x-buttons.button>
        <x-buttons.button variant="outline-white" href="{{ route('contact') }}">
            Contact Us
        </x-buttons.button>
    </x-sections.portfolio-hero>

    <x-sections.section id="portfolio-intro" align="center">
        @php
            $technologies = $projects->flatMap(fn ($project) => $project['technologies'])->unique()->values();
            $stats = [
                ['value' => $projects->count(), 'label' => 'Projects Shared'],
                ['value' => $categories->count(), 'label' => 'Service Categories'],
                ['value' => $technologies->count(), 'label' => 'Technologies Used'],
            ];
        @endphp

        <p class="mx-auto max-w-2xl text-lg leading-relaxed text-gray-600">
            {{ config('portfolio.intro', 'Every business is different, and so is every project. Browse real examples of the problems we solve, the solutions we design, and the technologies we work with.') }}
        </p>

        <dl class="mx-auto mt-10 grid max-w-3xl gap-6 sm:grid-cols-3">
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-gray-200/70 bg-surface px-6 py-6 text-center">
                    <dd class="text-3xl font-bold tracking-tight text-primary-600">{{ $stat['value'] }}</dd>
                    <dt class="mt-1 text-sm font-medium text-gray-600">{{ $stat['label'] }}</dt>
                </div>
            @endforeach
        </dl>
    </x-sections.section>

    <x-sections.section id="featured-projects" heading="Featured Projects" description="A selection of projects that show how we approach challenges, design solutions, and build for the long term.">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($featured as $project)
                <x-cards.featured-project-card :item="$project" />
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.section id="categories" heading="What We Build" description="From marketing websites to custom business software, every project fits within one of our service areas." variant="surface">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <x-cards.category-card :category="$category" />
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.section id="all-projects" heading="All Projects" description="Browse the full collection. Each project is shared as a sample or concept to illustrate our approach.">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)
                <x-cards.portfolio-card :item="$project" />
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.final-cta
        heading="Let's Build Your Next Digital Solution"
        description="Tell us about your project. We'll listen, ask the right questions, and recommend the approach that fits your business, no pressure, no obligation."
    />
</x-layouts.app>
