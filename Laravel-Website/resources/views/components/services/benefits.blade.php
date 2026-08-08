@props([
    'service' => [],
    'id' => 'business-benefits',
])

@php
    $benefits = $service['benefits'] ?? [];
    $heading = $benefits['heading'] ?? 'Business Benefits';
    $description = $benefits['description'] ?? '';
    $items = $benefits['items'] ?? [];
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="dark" align="center">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($items as $item)
            <x-cards.benefit-card
                :title="$item['title']"
                :description="$item['description'] ?? null"
                :icon="$item['icon'] ?? null"
                dark
            />
        @endforeach
    </div>
</x-sections.section>
