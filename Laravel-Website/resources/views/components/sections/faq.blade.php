@props([
    'id' => 'faq',
    'heading' => 'Frequently Asked Questions',
    'description' => 'Have questions? Here are answers to some of the most common enquiries we receive from businesses looking for digital solutions.',
    'items' => null,
    'variant' => 'surface',
])

@php
    $items = $items ?? collect(app(\App\Services\Content\ContentService::class)->faqs())
        ->where('status', 'active')
        ->where('featured', true)
        ->sortBy([
            fn ($item) => (int) ($item['priority'] ?? 10),
            fn ($item) => strtolower($item['question'] ?? ''),
        ])
        ->values();
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" :variant="$variant" align="center" background="contours">
    <div class="mx-auto max-w-3xl space-y-4 text-left">
        @foreach ($items as $item)
            <x-faq.accordion
                :question="$item['question']"
                :answer="$item['answer']"
                :links="$item['related_pages'] ?? []"
                :question-id="$item['id'] ?? null"
                group="faq-featured"
                :open="$loop->first"
                :index="$loop->index"
            />
        @endforeach
    </div>

    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
        <x-buttons.secondary-button href="{{ route('contact') }}">Contact Us</x-buttons.secondary-button>
    </div>
</x-sections.section>
