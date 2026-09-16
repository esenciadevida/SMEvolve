@props([
    'id' => 'ai-capabilities',
    'heading' => 'AI That Works for Your Business',
    'description' => "AI isn't just for tech giants. We build practical, focused AI solutions that solve real business problems — starting with what matters most to you.",
])

@php
    $capabilities = [
        [
            'title' => 'Intelligent Chatbots',
            'description' => 'AI-powered assistants that handle customer queries, qualify leads, and provide support around the clock — trained on your business knowledge.',
            'icon' => 'chat-bubble-left-ellipsis',
            'metric' => '24/7 availability',
        ],
        [
            'title' => 'Document Processing',
            'description' => 'Automated extraction, classification, and analysis of invoices, contracts, and reports — turning paperwork into structured data.',
            'icon' => 'document-text',
            'metric' => '85% time reduction',
        ],
        [
            'title' => 'Smart Analytics',
            'description' => 'AI-driven insights from your business data — trend detection, anomaly alerts, and predictive forecasting that guide better decisions.',
            'icon' => 'chart-bar',
            'metric' => 'Data-driven decisions',
        ],
        [
            'title' => 'Workflow Automation',
            'description' => 'Intelligent task routing, auto-categorization, and process optimization that learns from your operations and improves over time.',
            'icon' => 'cog-6-tooth',
            'metric' => 'Continuous improvement',
        ],
    ];
@endphp

<section data-reveal id="{{ $id }}" class="relative overflow-hidden bg-dark text-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-aurora opacity-40"></div>
        <div class="absolute inset-0 bg-dark/50"></div>
        <div class="absolute inset-0 bg-grid-dark mask-fade-edges opacity-50"></div>
    </div>

    <div class="relative mx-auto w-full max-w-site px-6 py-16 lg:px-8 lg:py-24">
        <header data-reveal class="max-w-3xl text-center mx-auto">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-secondary-300">
                <x-icon name="sparkles" class="h-3.5 w-3.5" />
                AI-Powered Solutions
            </span>
            <h2 class="mt-5 text-3xl font-bold tracking-tight text-balance sm:text-4xl">{{ $heading }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-slate-400">{{ $description }}</p>
        </header>

        <div data-reveal-group class="mt-14 grid gap-6 sm:grid-cols-2">
            @foreach ($capabilities as $cap)
                <article class="group relative rounded-2xl border border-white/10 bg-white/[0.04] p-6 transition duration-300 hover:border-white/20 hover:bg-white/[0.07] sm:p-8">
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-secondary-500/25 to-primary-500/25 text-white ring-1 ring-inset ring-white/10">
                            <x-icon :name="$cap['icon']" class="h-6 w-6" />
                        </div>
                        <span class="inline-flex items-center rounded-full bg-accent-500/15 px-2.5 py-1 text-[0.7rem] font-semibold text-accent-300">{{ $cap['metric'] }}</span>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-white">{{ $cap['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $cap['description'] }}</p>
                </article>
            @endforeach
        </div>

        <div data-reveal class="mt-14 grid gap-8 lg:grid-cols-[1.4fr_1fr] lg:items-center">
            <div>
                <h3 class="text-2xl font-bold tracking-tight">Start With One Problem. Scale From There.</h3>
                <p class="mt-3 text-base leading-relaxed text-slate-400">Most AI projects fail because they try to do everything at once. We take a different approach: identify your highest-impact pain point, build a focused solution, measure the results, and expand from there.</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <x-buttons.primary-button href="{{ route('quote') }}">
                        Discuss an AI Project
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </x-buttons.primary-button>
                    <x-buttons.button variant="outline-white" href="{{ route('services.show', 'ai-solutions') }}">
                        Explore AI Services
                    </x-buttons.button>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                @foreach (['Free AI readiness assessment', 'No jargon — plain language', 'Focused on measurable ROI', 'Scalable architecture'] as $point)
                    <div class="flex items-center gap-3 rounded-xl bg-white/[0.04] px-4 py-3 ring-1 ring-inset ring-white/[0.08]">
                        <span class="flex h-6 w-6 flex-none items-center justify-center rounded-full bg-accent-500/10">
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-400" />
                        </span>
                        <span class="text-sm text-slate-300">{{ $point }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
