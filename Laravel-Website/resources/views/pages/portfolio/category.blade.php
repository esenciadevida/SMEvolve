<x-layouts.app
    :title="$category['seoTitle'] ?? $category['name']"
    :description="$category['seoDescription'] ?? $category['description']"
    :canonical="route('portfolio.category', $category['slug'])"
>
    <x-sections.portfolio-hero
        eyebrow="Portfolio"
        heading="{{ $category['name'] }}"
        :description="$category['description']"
        :breadcrumb="[
            ['label' => 'Portfolio', 'url' => route('portfolio')],
            ['label' => $category['name']],
        ]"
        :projects="$projects"
        badge="{{ $projects->count() }} {{ Str::plural('Project', $projects->count()) }} in this Area"
    >
        <x-buttons.button variant="white" href="{{ route('quote') }}">
            Get a Free Quote
        </x-buttons.button>
        <x-buttons.button variant="outline-white" href="{{ route('portfolio') }}">
            View All Projects
        </x-buttons.button>
    </x-sections.portfolio-hero>

    <x-sections.section :id="'projects-'.$category['slug']" heading="Projects in {{ $category['name'] }}" :description="$category['seoDescription'] ?? $category['description']">
        @if ($projects->isEmpty())
            <p class="mx-auto max-w-xl text-center text-lg leading-relaxed text-gray-600">
                We're building this section of the portfolio. Get in touch to discuss a {{ Str::lower($category['name']) }} project.
            </p>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <x-cards.portfolio-card :item="$project" />
                @endforeach
            </div>
        @endif
    </x-sections.section>

    <x-sections.section id="explore-categories" heading="Explore Other Areas" description="Every project we build falls into one of these service categories." variant="surface">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories->reject(fn ($item) => $item['slug'] === $category['slug']) as $other)
                <x-cards.category-card :category="$other" />
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.final-cta
        heading="Let's Build Your Next Digital Solution"
        description="Tell us about your project. We'll listen, ask the right questions, and recommend the approach that fits your business, no pressure, no obligation."
    />
</x-layouts.app>
