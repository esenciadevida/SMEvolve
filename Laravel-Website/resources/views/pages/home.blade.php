@php
    $homeDescription = 'SMEvolve helps businesses build modern websites, custom software, mobile applications, and automation solutions designed around their unique goals.';

    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('company.name'),
        'url' => url('/'),
        'logo' => url('images/logo-light.png'),
        'description' => config('company.description'),
        'email' => config('company.contact.email'),
    ];

    $webSiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => config('company.name'),
        'url' => url('/'),
    ];
@endphp

<x-layouts.app
    :title="'SMEvolve | Digital Solutions for SMEs in Lagos, Nigeria'"
    :description="$homeDescription"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode($webSiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-slot>

    <x-sections.hero />

    <x-sections.technology-stack />

    <x-sections.services />

    <x-sections.why-choose />

    <x-sections.industries />

    <x-sections.process />

    <x-sections.portfolio-preview />

    <x-sections.faq />

    <x-sections.final-cta />
</x-layouts.app>
