@props([
    'service' => [],
    'id' => 'service-overview',
])

@php
    $overview = $service['overview'] ?? [];
    $heading = $overview['heading'] ?? 'Service Overview';
    $description = $overview['description'] ?? '';
    $paragraphs = $overview['paragraphs'] ?? [];
    $points = $overview['points'] ?? [];
@endphp

<x-sections.section :id="$id" :heading="$heading" :description="$description" variant="surface" align="center">
    <div class="mx-auto max-w-3xl space-y-5 text-lg leading-relaxed text-gray-600">
        @foreach ($paragraphs as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </div>

    @if (filled($points))
        <div class="mt-12 grid gap-4 sm:grid-cols-2">
            @foreach ($points as $point)
                <div class="flex items-start gap-3 rounded-2xl border border-gray-200/70 bg-white p-5 text-left shadow-sm dark:bg-dark-card">
                    <span class="mt-0.5 flex h-6 w-6 flex-none items-center justify-center rounded-full bg-accent-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-accent-500" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <p class="text-base font-medium leading-relaxed text-gray-800">{{ $point }}</p>
                </div>
            @endforeach
        </div>
    @endif
</x-sections.section>
