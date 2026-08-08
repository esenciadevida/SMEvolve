@php
    $aboutDescription = 'Learn about SMEvolve, a technology company helping businesses grow through modern websites, custom software, and reliable digital solutions.';
@endphp

<x-layouts.app
    :title="'About'"
    :description="$aboutDescription"
    :canonical="url()->current()"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'description' => $aboutDescription,
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
