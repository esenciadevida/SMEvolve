@php
    $sitemapDescription = 'Browse SMEvolve’s public website pages, services, portfolio projects, resources, and contact information in one place.';
    $contact = config('company.contact', []);
@endphp

<x-layouts.app
    :title="'Sitemap | '.config('app.name')"
    :description="$sitemapDescription"
    :canonical="route('sitemap.page')"
>
    <x-sections.page-hero
        full
        id="sitemap"
        eyebrow="Sitemap"
        heading="Explore every public page on SMEvolve"
        :description="$sitemapDescription"
        variant="dashboard"
        :breadcrumb="[['label' => 'Sitemap']]"
    />

    <x-sections.section heading="Main pages" description="Navigate the main public pages that describe our services, packages, portfolio, help, and contact information.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('home') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">Home</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">Overview of SMEvolve and what we build for growing businesses.</p>
            </a>
            <a href="{{ route('about') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">About</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">Learn who we are, how we work, and why SMEvolve exists.</p>
            </a>
            <a href="{{ route('services.index') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">Services</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">Explore our full range of website, software, app, and automation services.</p>
            </a>
            <a href="{{ route('packages') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">Packages</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">View service packages designed to fit small business budgets and goals.</p>
            </a>
            <a href="{{ route('portfolio') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">Portfolio</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">See examples of projects we’ve delivered for businesses like yours.</p>
            </a>
            <a href="{{ route('faq') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">FAQ</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">Find answers to common questions about working with SMEvolve.</p>
            </a>
            <a href="{{ route('contact') }}" class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">Contact</p>
                <p class="mt-3 text-base text-slate-700 dark:text-slate-300">Get in touch via email, phone, WhatsApp, or our contact form.</p>
            </a>
        </div>
    </x-sections.section>

    <x-sections.section heading="Our services" description="Direct links to every service page available on the SMEvolve website.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $service)
                <a href="{{ route('services.show', $service['slug']) }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $service['title'] ?? $service['name'] ?? str_replace('-', ' ', ucfirst($service['slug'])) }}</p>
                </a>
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.section heading="Portfolio categories" description="Browse project categories and case studies we publish for our clients.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($portfolioCategories as $category)
                <a href="{{ route('portfolio.category', $category['slug']) }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $category['name'] }}</p>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $category['projectCount'] ?? 0 }} project{{ ($category['projectCount'] ?? 0) === 1 ? '' : 's' }}</p>
                </a>
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.section heading="Portfolio projects" description="Explore individual portfolio case studies and published work.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($portfolioProjects as $project)
                <a href="{{ route('portfolio.show', $project['slug']) }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $project['title'] }}</p>
                </a>
            @endforeach
        </div>
    </x-sections.section>

    <x-sections.section heading="Resources and extras" description="Additional pages, legal resources, and technical sitemap endpoints.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('privacy-policy.index') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">Privacy Policy</p>
            </a>
            <a href="{{ route('terms.index') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">Terms & Conditions</p>
            </a>
            <a href="{{ route('cookies.index') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">Cookie Policy</p>
            </a>
            <a href="{{ route('sitemap') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">XML Sitemap</p>
            </a>
            <a href="{{ route('robots') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">Robots.txt</p>
            </a>
            <a href="{{ route('quote') }}" class="rounded-3xl border border-slate-200/80 bg-white/90 p-5 transition hover:border-primary-500 hover:bg-primary-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-primary-400">
                <p class="font-semibold text-slate-900 dark:text-white">Quote Wizard</p>
            </a>
        </div>
    </x-sections.section>

    <x-sections.section heading="Contact SMEvolve" description="Reach out if you'd like help building a website, app, or automation solution.">
        <div class="space-y-3 text-slate-700 dark:text-slate-300">
            @if (filled($contact['email'] ?? null))
                <p>Email: <a href="mailto:{{ $contact['email'] }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">{{ $contact['email'] }}</a></p>
            @endif
            @if (filled($contact['phone'] ?? null))
                <p>Phone: <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">{{ $contact['phone'] }}</a></p>
            @endif
            <p><a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">Send us a message via the contact page.</a></p>
        </div>
    </x-sections.section>
</x-layouts.app>
