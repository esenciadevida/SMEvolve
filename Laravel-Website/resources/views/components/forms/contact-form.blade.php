@php
    $contactToken = session('contact_token', '');
    $contactMethods = config('company.form.contact_methods', []);
    $subjectOptions = config('company.form.subject_options', []);
    $budgetOptions = config('company.form.budget_options', []);
@endphp

<x-sections.section
    id="contact-form"
    heading="Send Us a Message"
    description="Fill in the form below and we'll get back to you quickly, no jargon, no pressure."
    variant="white"
>
    <div class="mx-auto max-w-3xl">
        @if (session('contact_success'))
            <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })" class="mb-8">
                <x-shared.alert type="success" title="Thank you!">
                    <p>We've received your message. A member of the SMEvolve team will respond as soon as possible.</p>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <x-buttons.button href="{{ route('home') }}" variant="secondary">Return Home</x-buttons.button>
                        <x-buttons.button href="{{ route('services.index') }}" variant="secondary">Explore Services</x-buttons.button>
                    </div>
                </x-shared.alert>
            </div>
        @endif

        @if ($errors->any())
            <x-shared.alert type="error" title="There was a problem with your message" class="mb-8">
                <p>Please review the highlighted fields below and try again.</p>
                @if ($errors->has('contact_token'))
                    <p class="mt-1">{{ $errors->first('contact_token') }}</p>
                @endif
            </x-shared.alert>
        @endif

        <form
            method="POST"
            action="{{ route('contact') }}"
            class="rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card sm:p-8"
            x-data="contactForm"
            data-has-errors="{{ $errors->any() ? '1' : '0' }}"
            @focusin.once="track('contact_form:started')"
            @submit="submitting = true; track('contact_form:submitted')"
        >
            @csrf

            <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
            <input type="hidden" name="contact_token" value="{{ $contactToken }}">

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-forms.label for="name" required>Full Name</x-forms.label>
                    <x-forms.input name="name" id="name" type="text" placeholder="John Doe" autocomplete="name" required />
                    <x-forms.error for="name" :message="$errors->first('name')" />
                </div>

                <div>
                    <x-forms.label for="company" optional>Business Name</x-forms.label>
                    <x-forms.input name="company" id="company" type="text" placeholder="ABC Company Ltd." autocomplete="organization" />
                    <x-forms.error for="company" :message="$errors->first('company')" />
                </div>

                <div>
                    <x-forms.label for="email" required>Email Address</x-forms.label>
                    <x-forms.input name="email" id="email" type="email" placeholder="john@example.com" autocomplete="email" required />
                    <x-forms.error for="email" :message="$errors->first('email')" />
                </div>

                <div>
                    <x-forms.label for="phone" optional>Phone Number</x-forms.label>
                    <x-forms.input name="phone" id="phone" type="tel" placeholder="+234 XXX XXX XXXX" autocomplete="tel" />
                    <x-forms.error for="phone" :message="$errors->first('phone')" />
                </div>

                <div>
                    <x-forms.label for="contact_method" required>Preferred Contact Method</x-forms.label>
                    <x-forms.select name="contact_method" id="contact_method" :options="$contactMethods" placeholder="Please select" required />
                    <x-forms.error for="contact_method" :message="$errors->first('contact_method')" />
                </div>

                <div>
                    <x-forms.label for="subject" required>Subject</x-forms.label>
                    <x-forms.select name="subject" id="subject" :options="$subjectOptions" placeholder="Please select" required />
                    <x-forms.error for="subject" :message="$errors->first('subject')" />
                </div>

                <div class="sm:col-span-2">
                    <x-forms.label for="budget" optional>Estimated Budget</x-forms.label>
                    <x-forms.select name="budget" id="budget" :options="$budgetOptions" placeholder="Prefer not to say" />
                    <x-forms.error for="budget" :message="$errors->first('budget')" />
                </div>

                <div class="sm:col-span-2">
                    <x-forms.label for="message" required>Message</x-forms.label>
                    <x-forms.textarea name="message" id="message" rows="6" placeholder="Tell us about your project or enquiry..." required minlength="30" />
                    <x-forms.error for="message" :message="$errors->first('message')" />
                </div>
            </div>

            <div class="mt-6">
                <x-forms.checkbox name="consent" id="consent" value="1" required>
                    I agree to the Privacy Policy and consent to SMEvolve using my information to respond to this enquiry.
                </x-forms.checkbox>
                <x-forms.error for="consent" :message="$errors->first('consent')" />
            </div>

            <div class="mt-8 flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
                <x-buttons.button type="submit" x-bind:disabled="submitting" class="w-full sm:w-auto">
                    <span x-show="! submitting">Send Message</span>
                    <span x-show="submitting" x-cloak class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-0"></circle>
                        </svg>
                        Sending...
                    </span>
                </x-buttons.button>

                <p class="text-xs text-gray-500">We'll only use your information to respond to your enquiry.</p>
            </div>
        </form>
    </div>
</x-sections.section>
