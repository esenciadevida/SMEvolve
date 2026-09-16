@php
    $aboutDescription = 'Learn about SMEvolve, a digital solutions company serving businesses in Lagos and Nigeria with modern websites, custom software, AI chatbots, and automation solutions.';
@endphp

<x-layouts.app
    :title="'About SMEvolve'"
    :description="$aboutDescription"
    :canonical="route('about')"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'description' => $aboutDescription,
            'email' => config('company.contact.email'),
            'telephone' => config('company.contact.phone'),
            'areaServed' => [
                ['@type' => 'Place', 'name' => 'Lagos, Nigeria'],
                ['@type' => 'Country', 'name' => 'Nigeria'],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-slot>

    <x-sections.page-hero
        full
        id="about"
        eyebrow="About Us"
        heading="A Technology Company Built Around Your Business"
        description="We are SMEvolve, a team that designs, builds, and supports the digital products growing businesses rely on. Small enough to care deeply, experienced enough to deliver."
        variant="about"
        :breadcrumb="[['label' => 'About']]"
    />

    <x-sections.company-overview />

    <x-sections.our-story />

    <x-sections.mission-values />

    <x-sections.why-choose />

    <x-sections.team />

    <x-sections.final-cta />
</x-layouts.app>
