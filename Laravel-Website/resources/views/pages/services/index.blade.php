<x-layouts.app
    title="Digital Services for SMEs | SMEvolve"
    description="Explore the digital services SMEvolve offers, websites, e-commerce, custom software, mobile apps, AI, automation, and more, built to help your business grow."
    :canonical="route('services.index')"
>
    <x-slot name="structuredData">
        @php
            $listItems = collect($services)->map(fn ($service, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $service['name'],
                'url' => route('services.show', $service['slug']),
            ])->values();

            $structured = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => 'SMEvolve Services',
                'itemListElement' => $listItems,
            ];
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structured) !!}
        </script>
    </x-slot>

    <x-sections.page-hero
        id="services"
        eyebrow="Our Services"
        heading="Digital Services Built Around Your Business"
        description="From professional websites to custom software, mobile apps, and intelligent automation, we design and build digital solutions that help growing businesses work smarter and reach more customers."
        variant="services"
        :breadcrumb="[['label' => 'Services']]"
    />

    <section id="all-services" class="bg-surface" aria-labelledby="all-services-heading">
        <div class="mx-auto w-full max-w-site px-6 py-16 lg:px-8 lg:py-24">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">Explore Our Services</p>
                    <h2 id="all-services-heading" class="mt-3 text-3xl font-bold tracking-tight text-balance text-gray-900 sm:text-4xl">
                        Ten Core Services, One Focused Goal
                    </h2>
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                        Every project starts with your business goals. Explore what we offer and discover the right solution for your next step.
                    </p>
                </div>

                <div class="flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row">
                    <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
                    <x-buttons.secondary-button href="{{ route('contact') }}">Talk to Us</x-buttons.secondary-button>
                </div>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-cards.service-card
                        :title="$service['name']"
                        :description="$service['description']"
                        :icon="$service['icon']"
                        :url="route('services.show', $service['slug'])"
                    />
                @endforeach
            </div>

            <p class="mt-12 text-center text-sm text-gray-500">
                Don't see exactly what you need?
                <a href="{{ route('contact') }}" class="font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">Tell us about your project</a>
                and we build custom solutions for unique challenges.
            </p>
        </div>
    </section>

    <x-sections.faq variant="white" />

    <x-sections.final-cta
        heading="Not Sure Which Service You Need?"
        description="Tell us what you're trying to achieve and we'll recommend the right solution, no pressure, just a helpful conversation."
    />
</x-layouts.app>
