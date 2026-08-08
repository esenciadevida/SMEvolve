@php
    $meta = config('faqs.meta', []);

    $breadcrumbTrail = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'FAQ'],
    ];

    $organization = [
        '@type' => 'Organization',
        'name' => config('company.name'),
        'url' => url('/'),
    ];

    $webPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $meta['title'] ?? 'SMEvolve FAQ',
        'url' => route('faq'),
        'description' => $meta['description'] ?? '',
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faqs)->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
        ])->all(),
    ];
@endphp

<x-layouts.app
    :title="$meta['title'] ?? 'SMEvolve FAQ | Answers About Services, Pricing & Development'"
    :description="$meta['description'] ?? ''"
    :canonical="route('faq')"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode($webPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode(\App\Support\Breadcrumbs::schema($breadcrumbTrail), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        @if (collect($faqSchema['mainEntity'])->isNotEmpty())
            <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif
    </x-slot>

    <div x-data="faqSearch()">
        <script>
            window.FAQ_DATA = @json($faqs);
            window.FAQ_CATEGORIES = @json($categories);
        </script>

        <x-sections.page-hero
            id="faq"
            eyebrow="KNOWLEDGE CENTER"
            heading="Find Answers to Your Questions"
            description="Browse our frequently asked questions, search for answers instantly, or explore topics covering services, pricing, development, support, and more."
            variant="automation"
            :breadcrumb="[['label' => 'FAQ']]"
        >
            <x-slot name="visual">
                <x-faq.hero-preview />
            </x-slot>

            <x-buttons.button
                variant="primary"
                type="button"
                @click="focusSearch()"
                data-track="faq:hero:start-searching"
            >
                <x-icon name="magnifying-glass" class="h-4 w-4" />
                Start Searching
            </x-buttons.button>

            <x-buttons.button
                variant="secondary"
                :href="route('contact')"
                data-track="faq:hero:contact"
            >
                Contact Our Team
            </x-buttons.button>

            <x-buttons.button
                variant="outline-white"
                :href="route('quote')"
                data-track="faq:hero:quote"
            >
                Start Quote Wizard
            </x-buttons.button>
        </x-sections.page-hero>

        <x-faq.search
            :faqs="$faqs"
            :categories="$categories"
        />
    </div>

    <x-sections.final-cta context="faq" />
</x-layouts.app>
