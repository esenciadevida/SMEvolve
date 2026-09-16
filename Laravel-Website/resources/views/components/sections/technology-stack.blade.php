@props([
    'id' => 'technologies',
    'heading' => 'Built With Modern Technologies',
    'description' => 'We use modern technologies and development practices to create secure, scalable, and reliable digital solutions that support business growth.',
    'categories' => null,
])

@php
    $categories = $categories ?? config('website.technologies');
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="surface" align="center" background="grid-glow">
    <div data-reveal-group class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($categories as $category)
            <x-cards.technology-card
                :title="$category['title']"
                :description="$category['description'] ?? null"
                :technologies="$category['technologies'] ?? []"
                :icon="$category['icon'] ?? null"
            />
        @endforeach
    </div>
</x-sections.section>
