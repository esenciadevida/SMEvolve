<x-layouts.app
    :title="$service['meta']['title'] ?? $service['name']"
    :description="$service['meta']['description'] ?? $service['description']"
    :canonical="route('services.show', $service['slug'])"
>
    <x-slot name="structuredData">
        @php
            $structured = [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $service['name'],
                'description' => $service['meta']['description'] ?? $service['description'],
                'url' => route('services.show', $service['slug']),
                'provider' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'url' => config('app.url'),
                ],
            ];

            $breadcrumbSchema = \App\Support\Breadcrumbs::schema([
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services', 'url' => route('services.index')],
                ['label' => $service['name']],
            ]);

            $serviceFaqs = $service['faqs'] ?? [];
            $faqSchema = ! empty($serviceFaqs) ? [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                }, $serviceFaqs),
            ] : null;
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structured, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
            {!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        @if ($faqSchema)
            <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif
    </x-slot>

    <x-services.hero :service="$service" />

    <x-services.overview :service="$service" />

    <x-services.problems :service="$service" />

    <x-services.solution :service="$service" />

    <x-services.features :service="$service" />

    <x-services.benefits :service="$service" />

    <x-services.technologies :service="$service" />

    <x-sections.process />

    <x-sections.faq :items="$serviceFaqs" heading="Frequently Asked Questions" />

    <x-services.related :service="$service" :items="$relatedServices" />

    <x-sections.final-cta
        :heading="$service['hero']['heading'] ?? 'Ready to Build Something Great?'"
        description="Tell us about your project and we'll explore how this service can help your business grow."
    />
</x-layouts.app>
