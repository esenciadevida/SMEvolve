@props([
    'service' => [],
    'items' => null,
    'id' => 'related-services',
])

@php
    $related = $service['related'] ?? [];
    $heading = is_array($related) && isset($related['heading']) ? $related['heading'] : 'Related Services';
    $description = is_array($related) && isset($related['description']) ? $related['description'] : 'Explore more services designed to support your business at every stage of growth.';
    $items = $items ?? collect($related);
@endphp

@if (filled($items))
    <x-sections.section :id="$id" :heading="$heading" :description="$description" align="center">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                <x-cards.service-card
                    :title="$item['name']"
                    :description="$item['description'] ?? null"
                    :icon="$item['icon'] ?? null"
                    :url="route('services.show', $item['slug'])"
                />
            @endforeach
        </div>
    </x-sections.section>
@endif
