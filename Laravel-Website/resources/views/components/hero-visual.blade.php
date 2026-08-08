@props([
    'variant' => 'dashboard',
])

@php
    $badges = match ($variant) {
        'quote' => [
            ['icon' => 'pencil', 'label' => 'Tailored Proposal', 'sub' => 'Built around your needs'],
            ['icon' => 'check-circle', 'label' => 'Free & Clear', 'sub' => ''],
        ],
        'packages' => [
            ['icon' => 'banknotes', 'label' => 'Fixed Price', 'sub' => 'No hidden fees'],
            ['icon' => 'shield-check', 'label' => 'No Surprises', 'sub' => ''],
        ],
        'about' => [
            ['icon' => 'user-group', 'label' => 'One Team', 'sub' => 'Designers, developers & strategists'],
            ['icon' => 'heart', 'label' => 'SME-First', 'sub' => ''],
        ],
        'services' => [
            ['icon' => 'swatch', 'label' => 'Tailored Solutions', 'sub' => 'Built around your goals'],
            ['icon' => 'sparkles', 'label' => 'Full Stack', 'sub' => ''],
        ],
        'contact' => [
            ['icon' => 'lifebuoy', 'label' => 'Fast Response', 'sub' => 'Within one business day'],
            ['icon' => 'chat-bubble-left-right', 'label' => "Let's Talk", 'sub' => ''],
        ],
        'legal-privacy' => [
            ['icon' => 'lock-closed', 'label' => 'Data Protected', 'sub' => 'Confidential & secure'],
            ['icon' => 'shield-check', 'label' => 'Privacy First', 'sub' => ''],
        ],
        'legal-terms' => [
            ['icon' => 'document-text', 'label' => 'Clear Terms', 'sub' => 'Written plainly'],
            ['icon' => 'check-circle', 'label' => 'Fair & Balanced', 'sub' => ''],
        ],
        'legal-cookies' => [
            ['icon' => 'check-circle', 'label' => 'Your Choice', 'sub' => 'Manage anytime'],
            ['icon' => 'eye', 'label' => 'Transparent', 'sub' => ''],
        ],
        'growth' => [
            ['icon' => 'trending-up', 'label' => 'Steady Growth', 'sub' => 'Results that compound'],
            ['icon' => 'chart-bar', 'label' => 'Clear Insights', 'sub' => ''],
        ],
        'automation' => [
            ['icon' => 'clock', 'label' => 'Time Saved', 'sub' => 'Hours back every week'],
            ['icon' => 'bolt', 'label' => 'Automation Active', 'sub' => ''],
        ],
        default => [
            ['icon' => 'code', 'label' => 'Modern Technology', 'sub' => 'Built for growth'],
            ['icon' => 'sparkles', 'label' => 'Growth', 'sub' => ''],
        ],
    };

    $footer = match ($variant) {
        'quote' => [
            ['icon' => 'clock', 'label' => '2 Minutes', 'sub' => 'To complete', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'banknotes', 'label' => 'Free', 'sub' => 'No obligation', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'packages' => [
            ['icon' => 'banknotes', 'label' => 'Fixed Price', 'sub' => 'No surprises', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'shield-check', 'label' => 'Transparent', 'sub' => 'Clear scope', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'about' => [
            ['icon' => 'user-group', 'label' => 'One Team', 'sub' => 'From idea to launch', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'heart', 'label' => 'SME-First', 'sub' => 'Built around you', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'services' => [
            ['icon' => 'swatch', 'label' => 'Tailored', 'sub' => 'Fits your goals', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'rocket-launch', 'label' => 'Full Service', 'sub' => 'Strategy to support', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'contact' => [
            ['icon' => 'bolt', 'label' => 'Fast Reply', 'sub' => 'Within a day', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'lifebuoy', 'label' => 'Human Support', 'sub' => 'Real people', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'legal-privacy' => [
            ['icon' => 'lock-closed', 'label' => 'Your Data', 'sub' => 'Protected by default', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'shield-check', 'label' => 'Clear Policy', 'sub' => 'Plain language', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'legal-terms' => [
            ['icon' => 'document-text', 'label' => 'Clear Terms', 'sub' => 'Written plainly', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'check-circle', 'label' => 'Fair & Balanced', 'sub' => 'For both sides', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        'legal-cookies' => [
            ['icon' => 'check-circle', 'label' => 'Your Choice', 'sub' => 'Manage anytime', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'eye', 'label' => 'Transparent', 'sub' => 'Nothing hidden', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
        default => [
            ['icon' => 'shield-check', 'label' => 'Secure', 'sub' => 'Reliable by design', 'tint' => 'bg-accent-500/10 text-accent-500'],
            ['icon' => 'bolt', 'label' => 'Fast', 'sub' => 'Optimised for performance', 'tint' => 'bg-primary-600/10 text-primary-600'],
        ],
    };

    $aria = match ($variant) {
        'quote' => 'SMEvolve quote wizard illustration showing a proposal being built from project details, features and an estimated price',
        'packages' => 'SMEvolve packages illustration showing three fixed-price service tiers with a highlighted recommended option',
        'about' => 'SMEvolve about illustration showing the team avatar, mission statement and the values that guide our work',
        'services' => 'SMEvolve services illustration showing a grid of capabilities including websites, e-commerce, software, mobile, AI and automation',
        'contact' => 'SMEvolve contact illustration showing a friendly chat conversation and the ways you can reach our team',
        'legal-privacy' => 'SMEvolve privacy policy illustration showing a shield protecting your data with clear, plain-language commitments',
        'legal-terms' => 'SMEvolve terms and conditions illustration showing a clear, plain-language document of fair terms for both sides',
        'legal-cookies' => 'SMEvolve cookie policy illustration showing cookie categories you can control and manage at any time',
        'growth' => 'SMEvolve digital solutions illustration showing a business growth chart with rising metrics',
        'automation' => 'SMEvolve digital solutions illustration showing an automated business workflow with connected steps',
        default => 'SMEvolve digital solutions illustration showing a modern dashboard interface with analytics and security highlights',
    };
@endphp

<div role="img" aria-label="{{ $aria }}" class="relative w-full max-w-md lg:max-w-lg">
    <div class="animate-float rounded-3xl bg-gradient-to-br from-primary-600 via-secondary-600 to-accent-500 p-1.5 shadow-2xl shadow-primary-600/25">
        <div class="rounded-[1.375rem] bg-white p-5 dark:bg-dark-card sm:p-6">
            <div class="flex items-center justify-between">
                <div class="flex gap-1.5" aria-hidden="true">
                    <span class="h-3 w-3 rounded-full bg-error-500/70"></span>
                    <span class="h-3 w-3 rounded-full bg-warning-500/70"></span>
                    <span class="h-3 w-3 rounded-full bg-accent-500/70"></span>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg bg-gray-50 px-3 py-1.5 ring-1 ring-inset ring-gray-200" aria-hidden="true">
                    <x-icon name="globe-alt" class="h-3.5 w-3.5 text-gray-400" />
                    <span class="text-xs font-medium text-gray-500">smevolve.tech</span>
                </div>
            </div>

            @if ($variant === 'quote')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-900">Your Proposal</p>
                        <span class="rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">In Progress</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="code" class="h-4 w-4 text-primary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Website Project</p>
                                <p class="text-[10px] text-gray-500">Business website</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="pencil" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Features & Scope</p>
                                <p class="text-[10px] text-gray-500">8 features selected</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-accent-500/10 p-3 ring-1 ring-inset ring-accent-500/20">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-accent-500/20">
                                <x-icon name="bolt" class="h-4 w-4 text-accent-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Estimated Proposal</p>
                                <p class="text-[10px] text-gray-500">Refined by our team</p>
                            </div>
                            <span class="rounded-full bg-white px-2.5 py-1 text-[10px] font-bold text-accent-600 shadow-sm">₦850k</span>
                        </div>
                    </div>
                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                        <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-primary-600 to-accent-500"></div>
                    </div>
                    <p class="mt-1.5 text-[10px] font-medium text-gray-400">2 of 3 steps complete, takes under 3 minutes</p>
                </div>
            @elseif ($variant === 'packages')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-900">Simple, Fixed-Price Packages</p>
                        <span class="rounded-full bg-primary-600/10 px-2.5 py-1 text-[10px] font-bold text-primary-600">From ₦450k</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center justify-between rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 flex-none items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                    <x-icon name="bolt" class="h-3.5 w-3.5 text-gray-500" />
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Essential</p>
                                    <p class="text-[10px] text-gray-500">Marketing website</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-gray-900">₦450k</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-white p-3 ring-2 ring-inset ring-accent-500/40 dark:bg-dark-card">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 flex-none items-center justify-center rounded-lg bg-accent-500/10">
                                    <x-icon name="sparkles" class="h-3.5 w-3.5 text-accent-500" />
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Growth</p>
                                    <p class="text-[10px] text-gray-500">Best-seller</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-accent-600">₦950k</p>
                                <p class="text-[10px] font-semibold text-accent-500">Most Popular</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                    <x-icon name="rocket-launch" class="h-3.5 w-3.5 text-secondary-600" />
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Scale</p>
                                    <p class="text-[10px] text-gray-500">Advanced business site</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-gray-900">₦1.8m</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-center gap-1.5 rounded-lg bg-accent-500/10 px-3 py-2">
                        <x-icon name="shield-check" class="h-3.5 w-3.5 text-accent-500" />
                        <span class="text-[10px] font-semibold text-accent-600">No hidden fees, the price you see is the price you pay</span>
                    </div>
                </div>
            @elseif ($variant === 'about')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-primary-600 to-secondary-600 text-xs font-bold text-white ring-2 ring-white dark:ring-dark-card">A</span>
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-secondary-600 to-accent-500 text-xs font-bold text-white ring-2 ring-white dark:ring-dark-card">F</span>
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-accent-500 to-emerald-600 text-xs font-bold text-white ring-2 ring-white dark:ring-dark-card">M</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">The SMEvolve Team</p>
                            <p class="text-[10px] text-gray-500">Design · Code · Grow</p>
                        </div>
                    </div>
                    <div class="mt-3 flex items-start gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                            <x-icon name="target" class="h-4 w-4 text-primary-600" />
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Our Mission</p>
                            <p class="text-[10px] leading-relaxed text-gray-500">Helping SMEs grow with digital solutions that fit their budget.</p>
                        </div>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        <span class="rounded-full bg-primary-600/10 px-2.5 py-1 text-[10px] font-semibold text-primary-600">Care</span>
                        <span class="rounded-full bg-secondary-600/10 px-2.5 py-1 text-[10px] font-semibold text-secondary-600">Quality</span>
                        <span class="rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-semibold text-accent-600">Transparency</span>
                    </div>
                </div>
            @elseif ($variant === 'services')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-900">One Partner, Every Capability</p>
                        <span class="rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">10 Services</span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="device-desktop" class="h-4 w-4 text-primary-600" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">Websites</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="shopping-cart" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">E-commerce</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="cpu-chip" class="h-4 w-4 text-accent-500" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">Software</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="device-mobile" class="h-4 w-4 text-primary-600" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">Mobile</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="sparkles" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">AI</p>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="bolt" class="h-4 w-4 text-accent-500" />
                            </span>
                            <p class="text-[10px] font-semibold text-gray-600 dark:text-gray-300">Automation</p>
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'contact')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <p class="text-xs font-semibold text-gray-900">We Reply Fast</p>
                    <div class="mt-3 space-y-2">
                        <div class="max-w-[85%] rounded-2xl rounded-tl-md bg-gray-100 px-3.5 py-2.5 text-xs text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            Hi! I'd love a quote for a new website.
                        </div>
                        <div class="ml-auto max-w-[85%] rounded-2xl rounded-tr-md bg-gradient-to-r from-primary-600 to-secondary-600 px-3.5 py-2.5 text-xs text-white shadow-md shadow-primary-600/20">
                            Great! Share a few details and we'll send a proposal.
                        </div>
                    </div>
                    <div class="mt-3 space-y-1.5">
                        <div class="flex items-center gap-2.5 rounded-lg bg-white p-2.5 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <x-icon name="envelope" class="h-4 w-4 text-primary-600" />
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">hello@smevolve.com</span>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-lg bg-white p-2.5 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <x-icon name="phone" class="h-4 w-4 text-secondary-600" />
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">+234 800 000 0000</span>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-lg bg-white p-2.5 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <x-icon name="chat-bubble-left-right" class="h-4 w-4 text-accent-500" />
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">WhatsApp, usually the fastest</span>
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'legal-privacy')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/30">
                            <x-icon name="shield-check" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Your Data, Protected</p>
                            <p class="text-[10px] text-gray-500">Privacy by default</p>
                        </div>
                        <span class="ml-auto rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">Secure</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="clipboard-document-list" class="h-4 w-4 text-primary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">What we collect</p>
                                <p class="text-[10px] text-gray-500">Only what we need</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="eye" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">How we use it</p>
                                <p class="text-[10px] text-gray-500">Clear and limited</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="user-group" class="h-4 w-4 text-accent-500" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Your rights</p>
                                <p class="text-[10px] text-gray-500">Always respected</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'legal-terms')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/30">
                            <x-icon name="document-text" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Terms, Made Clear</p>
                            <p class="text-[10px] text-gray-500">No confusing legalese</p>
                        </div>
                        <span class="ml-auto rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">v1.0</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="briefcase" class="h-4 w-4 text-primary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">What we deliver</p>
                                <p class="text-[10px] text-gray-500">Scope & timelines</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="credit-card" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Payments & refunds</p>
                                <p class="text-[10px] text-gray-500">Fair and transparent</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="link" class="h-4 w-4 text-accent-500" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Fair for both sides</p>
                                <p class="text-[10px] text-gray-500">Your business & ours</p>
                            </div>
                            <x-icon name="check-circle" class="h-4 w-4 text-accent-500" />
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'legal-cookies')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/30">
                            <x-icon name="eye" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">Cookies, Your Choice</p>
                            <p class="text-[10px] text-gray-500">Manage what we store</p>
                        </div>
                        <span class="ml-auto rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">Your Choice</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="shield-check" class="h-4 w-4 text-primary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Essential</p>
                                <p class="text-[10px] text-gray-500">Required to work</p>
                            </div>
                            <span class="rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">Always on</span>
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="chart-bar" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Analytics</p>
                                <p class="text-[10px] text-gray-500">Help us improve</p>
                            </div>
                            <span class="flex h-5 w-9 items-center rounded-full bg-accent-500 p-0.5">
                                <span class="ml-auto h-4 w-4 rounded-full bg-white shadow"></span>
                            </span>
                        </div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="sparkles" class="h-4 w-4 text-accent-500" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Marketing</p>
                                <p class="text-[10px] text-gray-500">Relevant updates</p>
                            </div>
                            <span class="flex h-5 w-9 items-center rounded-full bg-gray-200 p-0.5">
                                <span class="h-4 w-4 rounded-full bg-white shadow"></span>
                            </span>
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'growth')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-900">Business Growth</p>
                        <span class="flex items-center gap-1 rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-500">
                            <x-icon name="trending-up" class="h-3 w-3" /> +184%
                        </span>
                    </div>
                    <svg viewBox="0 0 320 120" class="mt-3 h-28 w-full" fill="none">
                        <defs>
                            <linearGradient id="grow-line" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#2563eb" />
                                <stop offset="100%" stop-color="#10b981" />
                            </linearGradient>
                            <linearGradient id="grow-area" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#2563eb" stop-opacity="0.16" />
                                <stop offset="100%" stop-color="#2563eb" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path d="M6 104 C 46 96, 66 76, 96 78 S 160 92, 190 58 S 268 40, 314 18 L 314 120 L 6 120 Z" fill="url(#grow-area)" />
                        <path d="M6 104 C 46 96, 66 76, 96 78 S 160 92, 190 58 S 268 40, 314 18" stroke="url(#grow-line)" stroke-width="3" stroke-linecap="round" />
                        <circle cx="6" cy="104" r="4" fill="#2563eb" />
                        <circle cx="96" cy="78" r="4" fill="#4f46e5" />
                        <circle cx="190" cy="58" r="4" fill="#4f46e5" />
                        <circle cx="314" cy="18" r="5" fill="#10b981" />
                    </svg>
                    <div class="mt-2 flex justify-between text-[10px] font-medium text-gray-400">
                        <span>Jan</span><span>Mar</span><span>Jun</span><span>Sep</span><span>Dec</span>
                    </div>
                </div>
            @elseif ($variant === 'automation')
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <p class="text-xs font-semibold text-gray-900">Automation Workflow</p>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-primary-600/10">
                                <x-icon name="envelope" class="h-4 w-4 text-primary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">New Enquiry</p>
                                <p class="text-[10px] text-gray-500">Form submitted</p>
                            </div>
                            <span class="h-1.5 w-1.5 rounded-full bg-accent-500"></span>
                        </div>
                        <div class="flex justify-center"><span class="h-4 w-px bg-gray-200"></span></div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-secondary-600/10">
                                <x-icon name="credit-card" class="h-4 w-4 text-secondary-600" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Invoice Created</p>
                                <p class="text-[10px] text-gray-500">Auto-generated</p>
                            </div>
                            <span class="h-1.5 w-1.5 rounded-full bg-accent-500"></span>
                        </div>
                        <div class="flex justify-center"><span class="h-4 w-px bg-gray-200"></span></div>
                        <div class="flex items-center gap-3 rounded-lg bg-white p-3 ring-1 ring-inset ring-gray-100 dark:bg-dark-card dark:ring-slate-700">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-accent-500/10">
                                <x-icon name="bolt" class="h-4 w-4 text-accent-500" />
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900">Workflow Complete</p>
                                <p class="text-[10px] text-gray-500">Actions triggered</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-5 rounded-xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-inset ring-slate-100 dark:from-slate-800 dark:to-dark-card dark:ring-slate-700" aria-hidden="true">
                    <div class="flex h-32 items-end justify-center gap-2.5">
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-primary-600 to-primary-300" style="height: 45%"></div>
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-primary-600 to-primary-300" style="height: 62%"></div>
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-secondary-600 to-secondary-500" style="height: 48%"></div>
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-secondary-600 to-secondary-500" style="height: 74%"></div>
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-accent-500 to-emerald-400" style="height: 58%"></div>
                        <div class="w-9 rounded-t-xl bg-gradient-to-t from-accent-500 to-emerald-400" style="height: 88%"></div>
                    </div>
                    <div class="mt-3 flex justify-center gap-2.5">
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Mon</span>
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Tue</span>
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Wed</span>
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Thu</span>
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Fri</span>
                        <span class="w-9 text-center text-[10px] font-medium text-gray-400">Sat</span>
                    </div>
                </div>
            @endif

            <div class="mt-4 grid grid-cols-2 gap-3" aria-hidden="true">
                @foreach ($footer as $stat)
                    <div class="flex items-center gap-2.5 rounded-xl bg-gray-50 p-3 ring-1 ring-inset ring-gray-100">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg {{ $stat['tint'] }}">
                            <x-icon :name="$stat['icon']" class="h-4 w-4" />
                        </span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">{{ $stat['label'] }}</p>
                            <p class="text-[10px] text-gray-500">{{ $stat['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="absolute -bottom-6 -left-6 hidden animate-float-slow sm:block">
        <div class="flex items-center gap-2.5 rounded-2xl border border-gray-100 bg-white/90 px-4 py-3 shadow-xl shadow-slate-900/10 backdrop-blur dark:border-gray-200 dark:bg-dark-card/90">
            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white">
                <x-icon :name="$badges[0]['icon']" class="h-4 w-4" />
            </span>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $badges[0]['label'] }}</p>
                <p class="text-xs text-gray-500">{{ $badges[0]['sub'] }}</p>
            </div>
        </div>
    </div>

    <div class="absolute -right-3 -top-3 animate-float">
        <div class="flex items-center gap-1.5 rounded-full bg-gradient-to-r from-accent-500 to-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-accent-500/30">
            <x-icon :name="$badges[1]['icon']" class="h-3.5 w-3.5" />
            {{ $badges[1]['label'] }}
        </div>
    </div>
</div>
