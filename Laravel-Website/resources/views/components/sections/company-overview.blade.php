@props(['id' => 'company-overview'])

@php
    $paragraphs = (new \App\Data\AboutData())->overview();
    $intro = $paragraphs[0] ?? null;
    $body = array_slice($paragraphs, 1);
@endphp

<section id="{{ $id }}" class="bg-surface" aria-labelledby="{{ $id }}-heading">
    <div class="mx-auto grid max-w-site gap-12 px-6 py-16 lg:grid-cols-12 lg:gap-16 lg:px-8 lg:py-24">
        <div class="lg:col-span-5">
            <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">Who We Are</p>

            <h2 id="{{ $id }}-heading" class="mt-3 text-balance text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                A Technology Company Built Around Your Business
            </h2>

            @if ($intro)
                <p class="mt-6 text-lg leading-relaxed text-gray-600">{{ $intro }}</p>
            @endif

            <div class="mt-8 h-px w-24 bg-gradient-to-r from-primary-600 to-accent-500" aria-hidden="true"></div>

            <div class="mt-8 flex flex-wrap gap-4">
                <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
                <x-buttons.secondary-button href="{{ route('contact') }}">Contact Us</x-buttons.secondary-button>
            </div>
        </div>

        <div class="space-y-5 text-lg leading-relaxed text-gray-600 lg:col-span-7">
            @foreach ($body as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
</section>
