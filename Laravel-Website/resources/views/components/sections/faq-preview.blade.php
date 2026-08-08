@props([
    'id' => 'faq-preview',
    'tag' => 'contact',
    'take' => 6,
    'label' => 'Frequently Asked Questions',
    'heading' => 'Have Questions Before Contacting Us?',
    'description' => "We've answered some of the questions we receive most often. If you don't find what you're looking for, feel free to contact us directly.",
    'intro' => 'Quick answers to common pre-contact questions so you can reach out with confidence. Browse the full FAQ page for more.',
    'viewAllLabel' => 'View All FAQs',
    'viewAllHref' => null,
    'contactLabel' => null,
    'contactHref' => null,
    'variant' => 'white',
    'trackPrefix' => 'faq',
])

@php
    $faqItems = collect(app(\App\Services\Content\ContentService::class)->faqs())
        ->where('status', 'active')
        ->where('tag', $tag)
        ->values()
        ->take($take);
    $viewAllHref = $viewAllHref ?? route('faq');
    $contactHref = $contactHref ?? route('contact');
@endphp

<x-sections.section
    :id="$id"
    :heading="$heading"
    :description="$description"
    :variant="$variant"
>
    <div class="grid items-start gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)]">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">{{ $label }}</p>
            <p class="mt-4 text-base leading-relaxed text-gray-600">
                {{ $intro }}
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <x-buttons.secondary-button :href="$viewAllHref" data-track="{{ $trackPrefix }}:view-all">
                    {{ $viewAllLabel }}
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </x-buttons.secondary-button>

                @if ($contactLabel)
                    <x-buttons.primary-button :href="$contactHref" data-track="{{ $trackPrefix }}:contact">
                        {{ $contactLabel }}
                    </x-buttons.primary-button>
                @endif
            </div>
        </div>

        <div class="space-y-4 text-left">
            @foreach ($faqItems as $item)
                <x-faq.accordion
                    :question="$item['question']"
                    :answer="$item['answer']"
                    :links="$item['related_pages'] ?? []"
                    :question-id="$item['id'] ?? null"
                    group="faq-preview"
                    :open="$loop->first"
                    :index="$loop->index"
                />
            @endforeach
        </div>
    </div>
</x-sections.section>
