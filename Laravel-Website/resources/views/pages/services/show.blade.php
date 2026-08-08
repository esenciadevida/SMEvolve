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
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structured) !!}
        </script>
    </x-slot>

    <x-services.hero :service="$service" />

    <x-services.overview :service="$service" />

    <x-services.problems :service="$service" />

    <x-services.solution :service="$service" />

    <x-services.features :service="$service" />

    <x-services.benefits :service="$service" />

    <x-services.technologies :service="$service" />

    <x-sections.process />

    <x-sections.faq :items="$service['faqs'] ?? []" heading="Frequently Asked Questions" />

    <x-services.related :service="$service" :items="$relatedServices" />

    <x-sections.final-cta
        :heading="$service['hero']['heading'] ?? 'Ready to Build Something Great?'"
        description="Tell us about your project and we'll explore how this service can help your business grow."
    />
</x-layouts.app>
