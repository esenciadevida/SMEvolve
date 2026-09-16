@props([
    'id' => 'services',
    'heading' => 'How We Help Your Business Grow',
    'description' => 'Every business faces different challenges. We group our expertise around the outcomes that matter most to you — so you can focus on the result, not the technology.',
])

@php
    $groups = [
        [
            'heading' => 'Reach More Customers Online',
            'description' => "Your online presence is often the first impression customers have of your business. We build websites and stores that attract visitors, build trust, and convert interest into revenue.",
            'color' => 'primary',
            'services' => [
                ['slug' => 'website-development', 'name' => 'Professional Websites', 'icon' => 'globe-alt', 'point' => 'Responsive designs that look great on every device'],
                ['slug' => 'wordpress-development', 'name' => 'WordPress Solutions', 'icon' => 'device-desktop', 'point' => 'Fast, SEO-friendly sites you can manage yourself'],
                ['slug' => 'ecommerce-development', 'name' => 'Online Stores', 'icon' => 'shopping-cart', 'point' => 'Secure checkout, inventory management, and payment integration'],
            ],
        ],
        [
            'heading' => 'Work Smarter, Scale Faster',
            'description' => 'Manual processes and disconnected tools hold businesses back. We build custom systems that automate workflows, connect your data, and give your team the tools to move faster.',
            'color' => 'secondary',
            'services' => [
                ['slug' => 'custom-software', 'name' => 'Custom Software', 'icon' => 'rectangle-stack', 'point' => 'Purpose-built applications for your specific operations'],
                ['slug' => 'business-automation', 'name' => 'Business Automation', 'icon' => 'bolt', 'point' => 'Eliminate repetitive tasks and reduce human error'],
                ['slug' => 'api-development', 'name' => 'API & Integrations', 'icon' => 'code', 'point' => 'Connect your tools and systems seamlessly'],
            ],
        ],
        [
            'heading' => 'Future-Proof with Intelligence',
            'description' => 'AI and mobile technology are transforming how businesses operate. We help you stay ahead with intelligent tools and apps that enhance every customer touchpoint.',
            'color' => 'accent',
            'services' => [
                ['slug' => 'ai-solutions', 'name' => 'AI Solutions', 'icon' => 'cpu-chip', 'point' => 'Chatbots, document processing, and smart automation'],
                ['slug' => 'mobile-app-development', 'name' => 'Mobile Applications', 'icon' => 'device-mobile', 'point' => 'Cross-platform apps that keep customers engaged'],
            ],
        ],
    ];
@endphp

<section id="{{ $id }}" class="relative overflow-hidden bg-white dark:bg-dark">
    <div class="relative mx-auto w-full max-w-site px-6 py-12 lg:px-8 lg:py-16">
        <header class="max-w-3xl text-center mx-auto">
            <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">Our Expertise</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-balance text-gray-900 sm:text-4xl">{{ $heading }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-gray-600">{{ $description }}</p>
        </header>

        <div class="mt-12 space-y-12">
            @foreach ($groups as $group)
                <div class="relative rounded-2xl border border-gray-100 bg-gray-50/60 p-6 sm:p-8 dark:border-white/5 dark:bg-white/[0.02]">
                    <div class="lg:grid lg:grid-cols-[1fr_2fr] lg:gap-10">
                        <div class="mb-6 lg:mb-0">
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $group['heading'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-slate-400">{{ $group['description'] }}</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($group['services'] as $svc)
                                @php
                                    $service = collect(config('website.services'))->firstWhere('slug', $svc['slug']);
                                @endphp
                                <a href="{{ route('services.show', $svc['slug']) }}" class="group/card flex flex-col rounded-xl border border-gray-200/70 bg-white p-5 text-left shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:hover:border-white/25">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600/10 text-primary-600">
                                        <x-icon :name="$svc['icon']" class="h-5 w-5" />
                                    </div>
                                    <h4 class="mt-3 text-sm font-semibold text-gray-900 dark:text-white">{{ $svc['name'] }}</h4>
                                    <p class="mt-1.5 flex-1 text-xs leading-relaxed text-gray-500 dark:text-slate-400">{{ $svc['point'] }}</p>
                                    <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-primary-600 transition group-hover/card:translate-x-0.5 dark:text-primary-400">
                                        Learn more
                                        <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <x-buttons.primary-button href="{{ route('quote') }}">Get a Free Quote</x-buttons.primary-button>
            <x-buttons.secondary-button href="{{ route('services.index') }}">View All Services</x-buttons.secondary-button>
        </div>
    </div>
</section>
