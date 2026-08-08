@props([
    'id' => 'portfolio-preview',
    'heading' => 'Recent Projects',
    'description' => 'Explore sample and concept projects that show how we plan, design, and build digital solutions for growing businesses.',
    'items' => null,
])

@php
    $items = $items ?? (count(config('portfolio.items', [])) > 0 ? config('portfolio.items', []) : app(\App\Data\Portfolio\PortfolioData::class)->featured(3)->all());
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" align="center">
    @if (count($items) > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                <x-cards.portfolio-card :item="$item" />
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            <x-buttons.primary-button href="{{ route('portfolio') }}">View All Projects</x-buttons.primary-button>
        </div>
    @else
        <div class="mx-auto max-w-2xl rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center dark:border-gray-600 dark:bg-dark-card">
            <x-icon name="briefcase" class="mx-auto h-12 w-12 text-gray-300" />
            <h3 class="mt-4 text-lg font-semibold text-gray-900">We're Preparing Our Case Studies</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-gray-600">We're currently preparing our first public case studies. Check back soon to see the projects we've been building.</p>
            <div class="mt-6 flex justify-center">
                <x-buttons.primary-button href="{{ route('quote') }}">Start Your Project</x-buttons.primary-button>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <x-buttons.secondary-button href="{{ route('portfolio') }}">View All Projects</x-buttons.secondary-button>
        </div>
    @endif
</x-sections.section>
