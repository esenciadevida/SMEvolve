@php
    $steps = [
        ['icon' => 'pencil', 'title' => '1. Share your project', 'description' => 'Answer a handful of quick questions about what you want to build. Most people finish in 2-3 minutes.'],
        ['icon' => 'chat-bubble-left-right', 'title' => '2. Get clarity', 'description' => 'Optional AI assistance helps you describe your project or spot features you might have missed.'],
        ['icon' => 'document-text', 'title' => '3. Receive your proposal', 'description' => 'We review your answers and send a clear, tailored proposal with scope, timeline and a fixed price.'],
    ];
@endphp

<x-layouts.app
    :title="'Get a Free Quote'"
    description="Share a few details about your project and SMEvolve will prepare a clear, tailored proposal, including scope, timeline and next steps."
    :canonical="route('quote')"
    robots="noindex, follow"
>
    <x-sections.page-hero
        id="quote"
        eyebrow="Get a Quote"
        heading="Tell Us About Your Project"
        description="Answer a few quick questions and we'll prepare a clear, tailored proposal, including scope, timeline and next steps. No obligation, no pressure."
        variant="quote"
        :breadcrumb="[['label' => 'Get a Quote']]"
    >
        <form method="POST" action="{{ route('quote.start') }}" class="contents">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session_id }}">

            @if (session('quote_expired'))
                <p class="mb-2 flex items-start gap-2 rounded-xl border border-warning-500/40 bg-warning-500/10 px-4 py-3 text-sm text-warning-200">
                    <x-icon name="information-circle" class="mt-0.5 h-5 w-5 flex-none" />
                    <span>Your previous quote expired, so we'll start you a fresh one.</span>
                </p>
            @endif

            <x-buttons.button type="submit" variant="white" class="w-full sm:w-auto" data-track="quote:cta:start">
                {{ $has_active_session ? 'Continue My Quote' : 'Start My Free Quote' }}
                <x-icon name="arrow-right" class="h-4 w-4" />
            </x-buttons.button>
        </form>

        <x-buttons.button :href="route('contact')" variant="outline-white" class="w-full sm:w-auto" data-track="quote:cta:contact">
            Talk to Us Instead
        </x-buttons.button>

        <ul class="mt-2 flex w-full flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-300">
            <li class="flex items-center gap-2"><x-icon name="clock" class="h-5 w-5 text-accent-500" /> Takes 2-3 minutes</li>
            <li class="flex items-center gap-2"><x-icon name="lock-closed" class="h-5 w-5 text-accent-500" /> Your details stay private</li>
            <li class="flex items-center gap-2"><x-icon name="check-circle" class="h-5 w-5 text-accent-500" /> No obligation</li>
        </ul>
    </x-sections.page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-site px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">How it works</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    A clear path from idea to proposal
                </h2>
                <p class="mt-4 text-lg leading-relaxed text-gray-600 dark:text-gray-400">
                    No long forms, no sales calls just to get a quote. Share the essentials and get a proposal you can actually use.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($steps as $step)
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-700 dark:bg-dark-card">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/25">
                            <x-icon :name="$step['icon']" class="h-6 w-6" />
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-white">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $step['description'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <form method="POST" action="{{ route('quote.start') }}" class="inline-flex">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $session_id }}">
                    <x-buttons.button type="submit" class="w-full sm:w-auto" data-track="quote:cta:start:bottom">
                        {{ $has_active_session ? 'Continue My Quote' : 'Get Started' }}
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </x-buttons.button>
                </form>
                <p class="mt-4 text-sm text-gray-500">
                    Questions first?
                    <a href="{{ route('faq') }}" class="font-semibold text-primary-600 hover:text-primary-700">Read our FAQ</a>
                    or
                    <a href="{{ route('contact') }}" class="font-semibold text-primary-600 hover:text-primary-700">contact us</a>.
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
