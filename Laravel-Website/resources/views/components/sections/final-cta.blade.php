@props([
    'context' => null,
    'id' => null,
    'label' => null,
    'heading' => null,
    'description' => null,
    'primaryText' => null,
    'primaryHref' => null,
    'secondaryText' => null,
    'secondaryHref' => null,
    'trustNote' => null,
    'trust' => [],
])

@php
    $data = $context ? (config('cta.'.$context) ?? []) : [];

    $id = $id ?? 'final-cta';
    $label = $label ?? ($data['label'] ?? null);
    $heading = $heading ?? ($data['heading'] ?? 'Ready to Build Something Great?');
    $description = $description ?? ($data['description'] ?? "Whether you're launching a new business, improving an existing platform, or planning a custom digital solution, we're here to help. Let's discuss your goals and explore the right solution together.");
    $primaryText = $primaryText ?? ($data['primary']['label'] ?? 'Get a Free Quote');
    $primaryHref = $primaryHref ?? (isset($data['primary']['route']) ? route($data['primary']['route']) : null) ?? route('quote');
    $secondaryText = $secondaryText ?? ($data['secondary']['label'] ?? null);
    $secondaryHref = $secondaryHref ?? (isset($data['secondary']['route']) ? route($data['secondary']['route']) : null);
    $trustNote = $trustNote ?? ($data['trust_note'] ?? 'No pressure. No obligation. Just a conversation about your project and how we can help.');
    $trust = filled($trust) ? $trust : ($data['trust'] ?? []);

    $whatsapp = config('company.contact.whatsapp');
    $secondaryText = $secondaryText ?? ($whatsapp ? 'Chat on WhatsApp' : 'Contact Us');
    $secondaryHref = $secondaryHref ?? ($whatsapp ?: route('contact'));
@endphp

<section id="{{ $id }}" class="mx-auto w-full max-w-site px-6 pb-16 lg:px-8 lg:pb-24" aria-labelledby="{{ $id }}-heading">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 px-6 py-16 text-center text-white shadow-2xl shadow-primary-700/30 ring-1 ring-inset ring-white/15 sm:px-16 lg:py-20">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:2.25rem_2.25rem]"></div>
        <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-primary-400/20 blur-3xl" aria-hidden="true"></div>

        @if ($label)
            <p class="relative text-sm font-semibold uppercase tracking-widest text-primary-200">{{ $label }}</p>
        @endif

        <h2 id="{{ $id }}-heading" class="relative mx-auto max-w-2xl text-3xl font-bold tracking-tight text-balance sm:text-4xl">{{ $heading }}</h2>
        <p class="relative mx-auto mt-4 max-w-2xl text-lg leading-relaxed text-primary-100">{{ $description }}</p>

        <div class="relative mt-8 flex flex-wrap justify-center gap-4">
            <x-buttons.button variant="white" :href="$primaryHref" data-track="cta:{{ $context ?? 'default' }}:primary">{{ $primaryText }}</x-buttons.button>
            <x-buttons.button variant="outline-white" :href="$secondaryHref" data-track="cta:{{ $context ?? 'default' }}:secondary">{{ $secondaryText }}</x-buttons.button>
        </div>

        @if (filled($trust))
            <ul class="relative mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                @foreach ($trust as $item)
                    <li class="flex items-center gap-2 text-sm text-primary-100/90">
                        <x-icon name="check-circle" class="h-4 w-4 flex-none text-accent-400" />
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        @endif

        <p class="relative mt-6 text-sm text-primary-100/90">{{ $trustNote }}</p>
    </div>
</section>
