@props([
    'id' => 'how-we-help',
    'heading' => 'From Challenge to Solution',
    'description' => "Most businesses know technology can help — they just don't know where to start. Here's how we turn your challenges into measurable results.",
])

<section id="{{ $id }}" class="relative overflow-hidden bg-dark text-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-mesh opacity-70"></div>
        <div class="absolute inset-0 bg-noise"></div>
    </div>

    <div class="relative mx-auto w-full max-w-site px-6 py-12 lg:px-8 lg:py-16">
        <header class="max-w-3xl text-center mx-auto">
            <p class="text-sm font-semibold uppercase tracking-widest text-primary-400">How We Work</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-balance sm:text-4xl">{{ $heading }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-slate-400">{{ $description }}</p>
        </header>

        <div class="mt-12 space-y-0">
            @php
                $examples = [
                    [
                        'problem' => [
                            'heading' => 'Manual Processes Eating Your Time',
                            'text' => "Your team spends hours on repetitive tasks — copying data between spreadsheets, sending manual follow-ups, generating reports by hand. Errors creep in and nobody has time for strategic work.",
                        ],
                        'solution' => [
                            'heading' => 'Automated Workflows That Free Your Team',
                            'text' => "We map your workflow, identify bottlenecks, and build automation that handles routine tasks. Your team focuses on high-value work while the system runs in the background — 24/7.",
                        ],
                        'result' => '40+ hours saved monthly',
                        'icon' => 'bolt',
                    ],
                    [
                        'problem' => [
                            'heading' => 'Scattered Customer Information',
                            'text' => "Customer data lives in emails, spreadsheets, WhatsApp threads, and memory. Nobody has the full picture, and important follow-ups fall through the cracks.",
                        ],
                        'solution' => [
                            'heading' => 'One System, Complete Visibility',
                            'text' => "We build custom dashboards and CRM integrations that consolidate your customer data into a single source of truth. Every interaction tracked, every opportunity visible.",
                        ],
                        'result' => '2x faster response times',
                        'icon' => 'rectangle-stack',
                    ],
                    [
                        'problem' => [
                            'heading' => 'AI Feels Overwhelming and Unreachable',
                            'text' => "You hear about AI everywhere but don't know how it applies to your business. The tools seem complex, expensive, or built for tech companies — not for you.",
                        ],
                        'solution' => [
                            'heading' => 'Practical AI That Actually Works for You',
                            'text' => "We start with your specific pain point — maybe it's customer queries, document processing, or scheduling — and build a focused AI solution that delivers ROI from day one.",
                        ],
                        'result' => '3x faster customer support',
                        'icon' => 'cpu-chip',
                    ],
                ];
            @endphp

            @foreach ($examples as $i => $example)
                <div @class(['relative grid gap-8 lg:grid-cols-2 lg:gap-16', 'pt-14' => $i > 0])>
                    {{-- Problem --}}
                    <div class="relative rounded-2xl border border-red-500/15 bg-red-500/[0.04] p-6 sm:p-8">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500/15 text-red-400">
                                <x-icon name="x-mark" class="h-5 w-5" />
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-widest text-red-400">The Challenge</span>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-white">{{ $example['problem']['heading'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $example['problem']['text'] }}</p>
                    </div>

                    {{-- Arrow connector (hidden on mobile) --}}
                    <div aria-hidden="true" class="pointer-events-none absolute left-1/2 top-0 hidden -translate-x-1/2 translate-y-1/2 lg:block">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white shadow-lg shadow-primary-600/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </div>
                    </div>

                    {{-- Solution --}}
                    <div class="relative rounded-2xl border border-primary-500/15 bg-primary-500/[0.04] p-6 sm:p-8">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-500/15 text-primary-400">
                                <x-icon :name="$example['icon']" class="h-5 w-5" />
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-widest text-primary-400">Our Solution</span>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-white">{{ $example['solution']['heading'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $example['solution']['text'] }}</p>
                        <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-primary-500/10 px-3 py-1.5 text-xs font-semibold text-primary-300">
                            <x-icon name="check-circle" class="h-4 w-4" />
                            {{ $example['result'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            <x-buttons.button variant="outline-white" href="{{ route('quote') }}">
                Discuss Your Challenge
                <x-icon name="arrow-right" class="h-4 w-4" />
            </x-buttons.button>
        </div>
    </div>
</section>
