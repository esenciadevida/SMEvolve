@php
    $footerConfig = config('footer');
    $contact = config('company.contact', []);
    $businessHours = filled($footerConfig['business_hours'] ?? null)
        ? $footerConfig['business_hours']
        : (config('company.hours.summary_string') ?? null);
    $socials = collect(config('social_links.platforms', []))->filter(fn ($platform) => ($platform['enabled'] ?? false) && filled($platform['href'] ?? null));
    $phone = $contact['phone'] ?? null;
@endphp

<footer class="bg-dark text-slate-400">
    <div aria-hidden="true" class="h-px bg-gradient-to-r from-transparent via-primary-500/60 to-transparent"></div>

    <div class="mx-auto max-w-site px-6 py-16 lg:px-8 lg:py-20">
        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/[0.06] to-transparent p-6 sm:p-8">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-primary-400">Ready to build?</p>
                    <h2 class="mt-1 text-xl font-semibold text-white sm:text-2xl">Let's find the right solution for your business.</h2>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a
                        href="{{ route('quote') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400/60"
                        data-track="footer:cta-quote"
                    >
                        Get a Free Quote
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    @if (filled($phone))
                        <a
                            href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white/5 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400/60"
                            data-track="footer:cta-call"
                        >
                            <x-icon name="phone" class="h-4 w-4" />
                            Call Us
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div aria-hidden="true" class="my-10 h-px bg-white/10"></div>

        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div class="sm:col-span-2 xl:col-span-1">
                <x-logo dark size="h-14" />
                <p class="mt-4 max-w-sm text-sm leading-relaxed">{{ $footerConfig['company']['tagline'] }}</p>
                <p class="mt-3 max-w-sm text-sm leading-relaxed text-slate-500">{{ $footerConfig['company']['description'] }}</p>

                @if ($socials->isNotEmpty())
                    <ul class="mt-6 flex items-center gap-3" aria-label="Social media">
                        @foreach ($socials as $platform)
                            <li>
                                <a
                                    href="{{ $platform['href'] }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-white/5 text-slate-300 ring-1 ring-white/10 transition duration-200 hover:-translate-y-0.5 hover:bg-primary-600 hover:text-white hover:ring-primary-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400/60"
                                    aria-label="{{ $platform['label'] }}"
                                    data-track="footer:social"
                                    data-track-data="{{ json_encode(['platform' => $platform['platform']]) }}"
                                >
                                    <x-icon :name="$platform['platform']" class="h-5 w-5" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <nav aria-label="Services">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-300">Services</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach (config('navigation.footer.services') as $link)
                        <li>
                            <a href="{{ route($link['route'], $link['params'] ?? []) }}" class="transition hover:text-white" data-track="footer:link">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav aria-label="Company">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-300">Company</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach (config('navigation.footer.company') as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="transition hover:text-white" data-track="footer:link">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav aria-label="Resources">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-300">Resources</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach (config('navigation.footer.resources') as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="transition hover:text-white" data-track="footer:link">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav aria-label="Contact">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-300">Contact</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @if (filled($contact['email'] ?? null))
                        <li>
                            <a href="mailto:{{ $contact['email'] }}" class="transition hover:text-white" data-track="footer:email">{{ $contact['email'] }}</a>
                        </li>
                    @endif

                    @if (filled($contact['phone'] ?? null))
                        <li>
                            <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="transition hover:text-white" data-track="footer:phone">{{ $contact['phone'] }}</a>
                        </li>
                    @endif

                    @if (filled($contact['whatsapp'] ?? null))
                        <li>
                            <a href="{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" class="transition hover:text-white" data-track="footer:whatsapp">WhatsApp</a>
                        </li>
                    @endif

                    @if (filled($businessHours))
                        <li class="text-slate-500">{{ $businessHours }}</li>
                    @endif
                </ul>
            </nav>
        </div>

        <div class="mt-12 flex flex-col items-start justify-between gap-4 border-t border-white/10 pt-8 text-sm sm:flex-row sm:items-center">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

            <div class="flex flex-wrap items-center gap-6">
                <ul class="flex items-center gap-6">
                    @foreach ($footerConfig['bottom_links'] as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="transition hover:text-white" data-track="footer:link">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>

                <a
                    href="#top"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 text-slate-300 ring-1 ring-white/10 transition hover:bg-primary-600 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400/60"
                    aria-label="Back to top"
                    data-track="footer:back-to-top"
                >
                    <x-icon name="arrow-up" class="h-5 w-5" />
                </a>
            </div>
        </div>
    </div>
</footer>
