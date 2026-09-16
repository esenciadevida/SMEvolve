@props([
    'tracked' => false,
])

<div
    x-data="cookieConsent({ tracked: @json($tracked) })"
    x-cloak
    x-show="visible"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    role="region"
    aria-label="Cookie consent"
    class="fixed inset-x-0 bottom-0 z-40 px-4 pb-4 sm:inset-x-auto sm:bottom-6 sm:left-6 sm:w-full sm:max-w-md sm:px-0 sm:pb-0"
>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card-hover ring-1 ring-black/5 dark:border-slate-700 dark:bg-dark-card dark:ring-white/5">
        <h2 id="cookie-consent-title" class="text-sm font-semibold text-slate-800 dark:text-slate-100">Your privacy matters</h2>
        <p class="mt-2 text-xs leading-relaxed text-slate-600 dark:text-slate-400">
            We use analytics cookies to understand how visitors use our site and improve it. These are
            turned off until you give consent — no tracking happens before your choice.
        </p>
        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
            <button
                type="button"
                @click="acceptAll()"
                class="inline-flex flex-1 items-center justify-center rounded-xl bg-gradient-to-r from-primary-600 to-secondary-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm shadow-primary-600/25 transition hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2"
            >
                Accept all
            </button>
            <button
                type="button"
                @click="acceptEssential()"
                class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800"
            >
                Essential only
            </button>
        </div>
        <p class="mt-3 text-[10px] leading-relaxed text-slate-400 dark:text-slate-500">
            Read the
            <a href="{{ route('cookies.index') }}" class="font-medium text-primary-600 underline underline-offset-2 hover:text-primary-700 dark:text-primary-400">Cookie Policy</a>
            and
            <a href="{{ route('privacy-policy.index') }}" class="font-medium text-primary-600 underline underline-offset-2 hover:text-primary-700 dark:text-primary-400">Privacy Policy</a>.
        </p>
    </div>
</div>