@php
    $stepForField = [
        'project_type' => 'project_type',
        'project_description' => 'project_description',
        'full_name' => 'contact_information',
        'email' => 'contact_information',
        'phone' => 'contact_information',
    ];

    $blocks = [
        'Project' => [
            ['label' => 'Project type', 'value' => $review['project_type']],
            ['label' => 'Project description', 'value' => $review['project_description']],
            ['label' => 'Requirements', 'value' => implode(', ', $review['requirements'] ?: [])],
            ['label' => 'Additional features', 'value' => $review['additional_features']],
        ],
        'Business' => [
            ['label' => 'Business name', 'value' => $review['business_name']],
            ['label' => 'Industry', 'value' => $review['industry']],
            ['label' => 'Business description', 'value' => $review['business_description']],
        ],
        'Scope & timing' => [
            ['label' => 'Existing assets', 'value' => implode(', ', $review['existing_assets'] ?: [])],
            ['label' => 'Project stage', 'value' => $review['project_stage']],
            ['label' => 'Timeline', 'value' => $review['timeline']],
            ['label' => 'Budget range', 'value' => $review['budget_range']],
            ['label' => 'Additional information', 'value' => $review['additional_information']],
        ],
        'Contact' => [
            ['label' => 'Name', 'value' => $review['contact_name']],
            ['label' => 'Email', 'value' => $review['contact_email']],
            ['label' => 'Phone', 'value' => $review['contact_phone']],
            ['label' => 'Company', 'value' => $review['company_name']],
            ['label' => 'Preferred contact method', 'value' => $review['preferred_contact_method']],
        ],
    ];
@endphp

<x-layouts.app
    :title="'Review Your Quote Details'"
    description="Check your details before sending your request to SMEvolve."
    :canonical="route('quote')"
>
    <div class="bg-gray-50 py-10 dark:bg-dark lg:py-14">
        <div class="mx-auto max-w-site px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-6">
                <ol class="flex items-center gap-2 text-sm text-gray-500">
                    <li><a href="{{ route('home') }}" class="transition hover:text-primary-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('quote') }}" class="transition hover:text-primary-600">Get a Quote</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="font-medium text-gray-900" aria-current="page">Review</li>
                </ol>
            </nav>

            @include('quote.components.progress', [
                'steps' => $steps,
                'currentKey' => 'contact_information',
                'stepNumber' => $total_steps,
                'totalSteps' => $total_steps,
            ])

            <div class="mt-8 grid gap-10 lg:grid-cols-[1fr_20rem]">
                <div>
                    @if (! $is_ready)
                        <div class="mb-6">
                            <x-shared.alert type="warning" title="A few details are still missing">
                                <p class="mb-3">To send your request, please add:</p>
                                <ul class="list-inside list-disc space-y-1">
                                    @foreach ($missing_fields as $field)
                                        <li>
                                            <a
                                                href="{{ route('quote.show', [$session->uuid, 'step' => $stepForField[$field] ?? 'project_description']) }}"
                                                class="font-semibold underline decoration-warning-500/50 underline-offset-2 transition hover:text-warning-800"
                                            >
                                                {{ $field }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </x-shared.alert>
                        </div>
                    @endif

                    @if ($errors->has('submit'))
                        <div class="mb-6">
                            <x-shared.alert type="error" title="We couldn't submit your request">
                                {{ $errors->first('submit') }}
                            </x-shared.alert>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @foreach ($blocks as $heading => $rows)
                            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-dark-card sm:p-8">
                                <h2 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ $heading }}</h2>
                                <dl class="mt-4 space-y-3 text-sm">
                                    @foreach ($rows as $row)
                                        <div class="grid gap-1 sm:grid-cols-[12rem_1fr] sm:gap-4">
                                            <dt class="font-medium text-gray-500">{{ $row['label'] }}</dt>
                                            <dd class="text-gray-900 dark:text-gray-200">
                                                {{ $row['value'] ?: '-' }}
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </section>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            @if ($previous_step)
                                <x-buttons.button
                                    variant="secondary"
                                    :href="route('quote.show', [$session->uuid, 'step' => $previous_step])"
                                    class="w-full sm:w-auto"
                                >
                                    Back
                                </x-buttons.button>
                            @endif
                        </div>

                        <x-buttons.button
                            variant="secondary"
                            :href="route('quote.show', [$session->uuid, 'step' => 'project_type'])"
                            class="hidden sm:inline-flex"
                        >
                            Edit answers
                        </x-buttons.button>
                    </div>
                </div>

                <aside class="lg:sticky lg:top-24 lg:self-start">
                    <form method="POST" action="{{ route('quote.submit', $session->uuid) }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-dark-card">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $session_id }}">

                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white">Send your request</h2>

                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                            Your details are safe with us. We'll use them to prepare a clear, tailored proposal and contact you shortly.
                        </p>

                        <div class="mt-5 space-y-4">
                            @foreach ($consent_documents as $document)
                                <div class="flex items-start gap-3">
                                    <input
                                        type="checkbox"
                                        name="consent[]"
                                        value="{{ $document['document'] }}"
                                        id="consent-{{ $loop->index }}"
                                        class="mt-0.5 h-4 w-4 flex-none rounded border-gray-300 text-primary-600 shadow-sm focus:ring-2 focus:ring-primary-600/20"
                                        required
                                    >
                                    <label for="consent-{{ $loop->index }}" class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $document['label'] }}
                                        <span class="block text-xs text-gray-500">
                                            See our
                                            <a href="{{ route($document['route']) }}" target="_blank" rel="noopener" class="font-semibold text-primary-600 hover:text-primary-700">Privacy Policy</a>.
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <x-buttons.button
                            type="submit"
                            class="mt-6 w-full"
                            :disabled="! $is_ready"
                        >
                            Submit My Request
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </x-buttons.button>

                        @if (! $is_ready)
                            <p class="mt-3 text-center text-xs text-gray-500">Add the missing details above to enable submission.</p>
                        @endif
                    </form>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>
