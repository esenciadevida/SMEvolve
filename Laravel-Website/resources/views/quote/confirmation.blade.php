@php
    $contact = config('company.contact', []);
@endphp

<x-layouts.app
    :title="'Request Received'"
    description="Thank you, your quote request has been received. SMEvolve will get back to you shortly."
>
    <div class="bg-gray-50 py-16 dark:bg-dark lg:py-24">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700 dark:bg-dark-card sm:p-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-success-500/10">
                    <x-icon name="check-circle" class="h-10 w-10 text-success-600 dark:text-success-400" />
                </div>

                <h1 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Request Received
                </h1>

                <p class="mt-3 text-base leading-relaxed text-gray-600 dark:text-gray-400">
                    Thanks for sharing your project with SMEvolve. Your details have been received, and a member of our team
                    will get back to you shortly with a tailored proposal.
                </p>

                <div class="mt-6 inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-5 py-3 dark:border-gray-700 dark:bg-gray-800">
                    <span class="text-sm text-gray-500">Your reference:</span>
                    <span class="font-mono text-sm font-bold tracking-wide text-primary-700 dark:text-primary-300">{{ $reference }}</span>
                </div>

                @if ($contact_email)
                    <p class="mt-4 text-sm text-gray-500">
                        A copy of your request is heading to <span class="font-semibold text-gray-700">{{ $contact_email }}</span>.
                    </p>
                @endif
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-dark-card">
                    <x-icon name="document-text" class="mx-auto h-8 w-8 text-primary-600" />
                    <h2 class="mt-3 text-sm font-bold text-gray-900 dark:text-white">We review your request</h2>
                    <p class="mt-1 text-sm text-gray-500">Our team checks your requirements and scope.</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-dark-card">
                    <x-icon name="chat-bubble-left-right" class="mx-auto h-8 w-8 text-primary-600" />
                    <h2 class="mt-3 text-sm font-bold text-gray-900 dark:text-white">We reach out</h2>
                    <p class="mt-1 text-sm text-gray-500">We'll contact you to confirm details and answer questions.</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-dark-card">
                    <x-icon name="banknotes" class="mx-auto h-8 w-8 text-primary-600" />
                    <h2 class="mt-3 text-sm font-bold text-gray-900 dark:text-white">You get a tailored proposal</h2>
                    <p class="mt-1 text-sm text-gray-500">Clear scope, timeline and fixed-price estimate.</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <x-buttons.button :href="route('home')" data-track="quote:confirmation:home">Back to Home</x-buttons.button>
                <x-buttons.button variant="secondary" :href="route('portfolio')" data-track="quote:confirmation:portfolio">See Our Work</x-buttons.button>
            </div>

            <p class="mt-10 text-center text-sm text-gray-500">
                Want to speak to us right away?
                @if (! empty($contact['phone']))
                    Call <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="font-semibold text-primary-600 hover:text-primary-700">{{ $contact['phone'] }}</a>
                @endif
                @if (! empty($contact['phone']) && ! empty($contact['email'])) · @endif
                @if (! empty($contact['email']))
                    email <a href="mailto:{{ $contact['email'] }}" class="font-semibold text-primary-600 hover:text-primary-700">{{ $contact['email'] }}</a>
                @endif
            </p>
        </div>
    </div>
</x-layouts.app>
