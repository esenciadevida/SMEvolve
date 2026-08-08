@php
    $contactDescription = 'Contact SMEvolve to discuss your website, software, AI, or digital transformation project. Reach us by phone, email, WhatsApp, or our online contact form.';

    $whatsapp = config('company.contact.whatsapp');
    $secondaryHref = $whatsapp ?: '#contact-form';
    $secondaryLabel = $whatsapp ? 'Chat on WhatsApp' : 'Send a Message';

    $heroBreadcrumb = [['label' => 'Contact']];
    $breadcrumbSchema = [['label' => 'Home', 'url' => route('home')], ['label' => 'Contact']];

    $faqItems = collect(config('faqs.items', []))->where('tag', 'contact')->values()->take(6);

    $contactPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => 'Contact SMEvolve',
        'url' => route('contact'),
        'description' => $contactDescription,
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => config('company.name'),
            'url' => url('/'),
            'telephone' => config('company.contact.phone'),
            'email' => config('company.contact.email'),
            'address' => config('company.address.formatted'),
        ],
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
    :title="'Contact SMEvolve | Let\'s Discuss Your Next Project'"
    :description="$contactDescription"
    :canonical="route('contact')"
>
    <x-slot name="structuredData">
        <script type="application/ld+json">
        {!! json_encode($contactPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode(\App\Support\Breadcrumbs::schema($breadcrumbSchema), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        @if ($faqItems->isNotEmpty())
            <script type="application/ld+json">
            {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif
    </x-slot>

    <x-sections.page-hero
        id="contact"
        eyebrow="Contact SMEvolve"
        heading="Let's Build Something Great Together"
        description="Whether you're planning a new website, custom software, AI-powered solution, or simply have a question, our team is ready to help. Reach out using your preferred method and we'll respond as quickly as possible."
        variant="contact"
        :breadcrumb="$heroBreadcrumb"
    >
        <x-buttons.button href="{{ route('quote') }}" variant="white" class="w-full sm:w-auto" data-track="contact:cta:quote">
            Get a Free Quote
        </x-buttons.button>
        <x-buttons.button :href="$secondaryHref" variant="outline-white" class="w-full sm:w-auto" data-track="contact:cta:whatsapp">
            {{ $secondaryLabel }}
        </x-buttons.button>

        <ul class="mt-2 flex w-full flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-300">
            <li class="flex items-center gap-2"><x-icon name="check-circle" class="h-5 w-5 text-accent-500" /> Fast Response</li>
            <li class="flex items-center gap-2"><x-icon name="check-circle" class="h-5 w-5 text-accent-500" /> Friendly Support</li>
            <li class="flex items-center gap-2"><x-icon name="check-circle" class="h-5 w-5 text-accent-500" /> No Obligation Consultation</li>
        </ul>
    </x-sections.page-hero>

    <x-sections.contact-information />

    <x-forms.contact-form />

    <x-sections.map-service-area />

    <x-sections.business-hours />

    <x-sections.faq-preview />
</x-layouts.app>
