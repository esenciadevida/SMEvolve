@php
    $meta = config('packages.meta', []);
    $packages = $websitePackages['items'] ?? [];
    $recommendedSlug = $websitePackages['recommended'] ?? null;
    $featureRows = $comparison['feature_rows'] ?? [];

    $philosophyModels = $philosophy['models'] ?? [];
    $philosophyFactors = $philosophy['factors'] ?? [];
    $philosophyWhyQuote = $philosophy['why_quote'] ?? [];
    $philosophyRecommendation = $philosophy['recommendation'] ?? [];

    $customServices = $customSolutions['services'] ?? [];
    $customDiscovery = $customSolutions['discovery'] ?? [];
    $customCta = $customSolutions['cta'] ?? ['label' => 'Request Custom Quote', 'route' => 'quote'];
    $customPrimary = $customSolutions['primary'] ?? ['label' => 'Start Quote Wizard', 'route' => 'quote'];
    $customSecondary = $customSolutions['secondary'] ?? ['label' => 'Talk to an Expert', 'route' => 'contact'];

    $breadcrumbTrail = [['label' => 'Home', 'url' => route('home')], ['label' => 'Packages']];

    $organization = [
        '@type' => 'Organization',
        'name' => config('company.name'),
        'url' => url('/'),
    ];

    $webPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $meta['title'] ?? 'SMEvolve Packages',
        'url' => route('packages'),
        'description' => $meta['description'] ?? '',
    ];

    $packageListSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'SMEvolve Website Packages',
        'itemListElement' => collect($packages)->map(fn ($package, $index) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'item' => [
                '@type' => 'Service',
                'name' => $package['name'] ?? '',
                'description' => $package['description'] ?? '',
                'url' => route('packages'),
                'provider' => $organization,
                'areaServed' => 'Worldwide',
                'audience' => ['@type' => 'Audience', 'name' => implode(', ', $package['target_audience'] ?? [])],
            ],
        ])->all(),
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqItems->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
        ])->all(),
    ];
@endphp

<x-layouts.app
    :title="$meta['title'] ?? 'SMEvolve Packages | Website & Custom Software Solutions'"
    :description="$meta['description'] ?? ''"
    :canonical="route('packages')"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode($webPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode(\App\Support\Breadcrumbs::schema($breadcrumbTrail), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        @if (collect($packageListSchema['itemListElement'])->isNotEmpty())
            <script type="application/ld+json">
            {!! json_encode($packageListSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif
        @if ($faqItems->isNotEmpty())
            <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif
    </x-slot>

    <x-sections.page-hero
        id="packages"
        :eyebrow="$hero['eyebrow'] ?? 'PACKAGES & PRICING'"
        :heading="$hero['heading'] ?? 'Flexible Packages for Every Stage of Your Business'"
        :description="$hero['description'] ?? ''"
        variant="packages"
        :breadcrumb="[['label' => 'Packages']]"
        :notice="$hero['notice'] ?? null"
    >
        <x-buttons.button
            variant="white"
            :href="route($hero['primary']['route'] ?? 'quote')"
            class="w-full sm:w-auto"
            data-track="packages:cta:quote"
        >
            {{ $hero['primary']['label'] ?? 'Request a Free Quote' }}
            <x-icon name="arrow-right" class="h-4 w-4" />
        </x-buttons.button>

        <x-buttons.button
            variant="outline-white"
            :href="$hero['secondary']['href'] ?? '#compare'"
            class="w-full sm:w-auto"
            data-track="packages:compare"
        >
            {{ $hero['secondary']['label'] ?? 'Compare Packages' }}
        </x-buttons.button>

        @if (filled($hero['trust'] ?? []))
            <ul class="mt-2 flex w-full flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-300">
                @foreach ($hero['trust'] as $item)
                    <li class="flex items-center gap-2">
                        <x-icon name="check-circle" class="h-5 w-5 text-accent-500" />
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        @endif
    </x-sections.page-hero>

    <x-sections.section
        id="pricing-philosophy"
        :eyebrow="$philosophy['label'] ?? 'OUR PRICING APPROACH'"
        :heading="$philosophy['heading'] ?? 'Transparent Pricing. Tailored Solutions.'"
        :description="$philosophy['description'] ?? ''"
        variant="surface"
    >
        <div class="grid items-start gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.1fr)]">
            <div>
                @if (filled($philosophyFactors))
                    <h3 class="text-xl font-semibold tracking-tight text-gray-900">{{ $philosophyFactors['heading'] ?? 'Factors That Influence Pricing' }}</h3>
                    <p class="mt-2 text-base leading-relaxed text-gray-600">{{ $philosophyFactors['description'] ?? '' }}</p>
                    <ul class="mt-5 grid gap-x-6 gap-y-2.5 sm:grid-cols-2">
                        @foreach ($philosophyFactors['items'] ?? [] as $factor)
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                                <span>{{ $factor }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if (filled($philosophyWhyQuote))
                    <div class="mt-8 rounded-2xl border border-primary-600/20 bg-primary-50/50 p-6">
                        <h3 class="text-base font-semibold tracking-tight text-gray-900">{{ $philosophyWhyQuote['heading'] ?? 'Why Some Projects Require a Quote' }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $philosophyWhyQuote['description'] ?? '' }}</p>
                    </div>
                @endif
            </div>

            @if (filled($philosophyModels))
                <div class="grid gap-6">
                    <x-cards.pricing-model-card :model="$philosophyModels['standard'] ?? []" />
                    <x-cards.pricing-model-card :model="$philosophyModels['custom'] ?? []" />
                </div>
            @endif
        </div>

        @if (filled($philosophyRecommendation))
            <div class="mt-12">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 px-6 py-10 text-center text-white shadow-2xl shadow-primary-700/30 sm:px-12">
                    <div class="pointer-events-none absolute -left-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -bottom-16 -right-16 h-56 w-56 rounded-full bg-primary-400/20 blur-3xl" aria-hidden="true"></div>

                    <h3 class="relative text-2xl font-bold tracking-tight">{{ $philosophyRecommendation['title'] ?? 'Not sure which option is right for you?' }}</h3>
                    <p class="relative mx-auto mt-3 max-w-2xl text-base leading-relaxed text-primary-100">{{ $philosophyRecommendation['description'] ?? '' }}</p>
                    <div class="relative mt-7">
                        <x-buttons.button
                            variant="white"
                            :href="route($philosophyRecommendation['cta']['route'] ?? 'quote')"
                            data-track="packages:philosophy:quote"
                        >
                            {{ $philosophyRecommendation['cta']['label'] ?? 'Start Quote Wizard' }}
                        </x-buttons.button>
                    </div>
                </div>
            </div>
        @endif

        @if (filled($philosophy['trust'] ?? []))
            <ul class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                @foreach ($philosophy['trust'] as $item)
                    <li class="flex items-center gap-2 text-sm font-medium text-gray-600">
                        <x-icon name="check-circle" class="h-4 w-4 flex-none text-accent-500" />
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        @endif
    </x-sections.section>

    <x-sections.section
        id="website-packages"
        :eyebrow="$websitePackages['label'] ?? 'WEBSITE PACKAGES'"
        :heading="$websitePackages['heading'] ?? 'Professional Websites Built for Business Growth'"
        :description="$websitePackages['description'] ?? ''"
        variant="white"
    >
        @if (filled($packages))
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($packages as $package)
                    <x-cards.package-card
                        :package="$package"
                        :recommended="($package['slug'] ?? null) === $recommendedSlug"
                    />
                @endforeach
            </div>
        @else
            <x-shared.empty-state title="No packages available" description="Check back soon, we're preparing our website packages." />
        @endif

        <p class="mt-10 text-center text-sm text-gray-500">
            Need something beyond a standard package?
            <a href="{{ route('quote') }}" class="font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">Request a custom quote</a>
            and we build solutions tailored to your exact requirements.
        </p>
    </x-sections.section>

    <x-sections.section
        id="custom-solutions"
        :eyebrow="$customSolutions['label'] ?? 'CUSTOM SOLUTIONS'"
        :heading="$customSolutions['heading'] ?? 'Need Something Built Specifically for Your Business?'"
        :description="$customSolutions['description'] ?? ''"
        variant="surface"
    >
        @if (filled($customServices))
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($customServices as $service)
                    <x-cards.service-card
                        :title="$service['name'] ?? ''"
                        :description="$service['description'] ?? ''"
                        :icon="$service['icon'] ?? null"
                        :points="$service['examples'] ?? []"
                        :url="route($customCta['route'] ?? 'quote')"
                        :action-label="$customCta['label'] ?? 'Request Custom Quote'"
                        data-track="packages:custom:service"
                        data-track-data="{{ json_encode(['service' => $service['slug'] ?? null]) }}"
                    />
                @endforeach
            </div>
        @endif

        @if (filled($customDiscovery['steps'] ?? []))
            <div class="mt-16">
                <div class="mx-auto max-w-2xl text-center">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">{{ $customDiscovery['heading'] ?? 'A Simple, Structured Discovery Process' }}</h3>
                    <p class="mt-3 text-base leading-relaxed text-gray-600">{{ $customDiscovery['description'] ?? '' }}</p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($customDiscovery['steps'] as $step)
                        <x-cards.process-step-card
                            :step="$step['step'] ?? null"
                            :title="$step['title'] ?? ''"
                            :description="$step['description'] ?? ''"
                            :icon="$step['icon'] ?? null"
                        />
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-12 rounded-2xl border border-primary-600/20 bg-primary-50/50 p-6 sm:p-8">
            <p class="flex items-start gap-3 text-base leading-relaxed text-gray-700">
                <x-icon name="information-circle" class="mt-0.5 h-6 w-6 flex-none text-primary-600" />
                <span>{{ $customSolutions['panel'] ?? 'Every custom project begins with understanding your business objectives before recommending technology or estimating cost.' }}</span>
            </p>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <x-buttons.primary-button :href="route($customPrimary['route'] ?? 'quote')" data-track="packages:custom:quote">
                {{ $customPrimary['label'] ?? 'Start Quote Wizard' }}
            </x-buttons.primary-button>
            <x-buttons.secondary-button :href="route($customSecondary['route'] ?? 'contact')" data-track="packages:custom:contact">
                {{ $customSecondary['label'] ?? 'Talk to an Expert' }}
            </x-buttons.secondary-button>
        </div>

        @if (filled($customSolutions['trust'] ?? []))
            <ul class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                @foreach ($customSolutions['trust'] as $item)
                    <li class="flex items-center gap-2 text-sm font-medium text-gray-600">
                        <x-icon name="check-circle" class="h-4 w-4 flex-none text-accent-500" />
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        @endif
    </x-sections.section>

    <x-sections.section
        id="compare"
        :eyebrow="$comparison['label'] ?? 'COMPARE PACKAGES'"
        :heading="$comparison['heading'] ?? 'Find the Package That Fits Your Business'"
        :description="$comparison['description'] ?? ''"
        variant="white"
    >
        @if (filled($packages) && filled($featureRows))
            <div class="hidden lg:block">
                <x-comparison.table
                    :packages="$packages"
                    :features="$featureRows"
                    :cta="$comparison['cta'] ?? ['label' => 'Request Quote', 'route' => 'quote']"
                    :recommended="$recommendedSlug"
                />
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:hidden">
                @foreach ($packages as $package)
                    <x-comparison.card
                        :package="$package"
                        :features="$featureRows"
                        :cta="$comparison['cta'] ?? ['label' => 'Request Quote', 'route' => 'quote']"
                        :recommended="($package['slug'] ?? null) === $recommendedSlug"
                        :index="$loop->index"
                    />
                @endforeach
            </div>
        @else
            <x-shared.empty-state title="No comparison available" description="Package comparison will be available soon." />
        @endif
    </x-sections.section>

    <x-sections.faq-preview
        id="pricing-faqs"
        :tag="$faqSection['tag'] ?? 'packages'"
        :take="$faqSection['take'] ?? 6"
        :label="$faqSection['label'] ?? 'PRICING QUESTIONS'"
        :heading="$faqSection['heading'] ?? 'Frequently Asked Questions About Our Packages'"
        :description="$faqSection['description'] ?? ''"
        :intro="$faqSection['intro'] ?? ''"
        :view-all-label="$faqSection['view_all']['label'] ?? 'View All FAQs'"
        :view-all-href="route($faqSection['view_all']['route'] ?? 'faq')"
        :contact-label="$faqSection['contact']['label'] ?? 'Still Have Questions?'"
        :contact-href="route($faqSection['contact']['route'] ?? 'contact')"
        variant="surface"
        track-prefix="packages:faq"
    />

    <x-sections.final-cta context="packages" />
</x-layouts.app>
