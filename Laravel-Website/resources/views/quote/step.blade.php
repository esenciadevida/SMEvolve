@php
    $aiConfig = [
        'aiEnabled' => $ai_available,
        'csrfToken' => csrf_token(),
        'sessionId' => $session_id,
        'suggestUrl' => route('quote.ai.suggest-features', $session->uuid),
        'improveUrl' => route('quote.ai.improve-description', $session->uuid),
    ];

    $descriptionQuestion = collect($questions)->firstWhere('ai_enabled', 'description');
    $featuresQuestion = collect($questions)->firstWhere('ai_enabled', 'features');
@endphp

<x-layouts.app
    :title="'Get a Quote, '.($step['label'] ?? 'Your Project')"
    :description="($step['description'] ?? null) ?: 'Answer a few quick questions and SMEvolve will prepare a tailored proposal for you.'"
    :canonical="route('quote')"
>
    <div class="bg-gray-50 py-10 dark:bg-dark lg:py-14">
        <div class="mx-auto max-w-site px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-6">
                <ol class="flex items-center gap-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('home') }}" class="transition hover:text-primary-600">Home</a>
                    </li>
                    <li aria-hidden="true">/</li>
                    <li>
                        <a href="{{ route('quote') }}" class="transition hover:text-primary-600">Get a Quote</a>
                    </li>
                    <li aria-hidden="true">/</li>
                    <li class="font-medium text-gray-900" aria-current="page">{{ $step['label'] ?? 'Wizard' }}</li>
                </ol>
            </nav>

            @include('quote.components.progress', [
                'steps' => $steps,
                'currentKey' => $step_key,
                'stepNumber' => $step_number,
                'totalSteps' => $total_steps,
            ])

            <div class="mt-8 grid gap-10 lg:grid-cols-[1fr_20rem]">
                <div>
                    @if (session('quote_expired'))
                        <x-shared.alert type="warning" title="Your previous quote expired">
                            It's been a while since your last activity, so we started a fresh quote for you. You can pick up right where you'd like.
                        </x-shared.alert>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6">
                            <x-shared.alert type="error" title="Please check the following">
                                <ul class="list-inside list-disc space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </x-shared.alert>
                        </div>
                    @endif

                    <div x-data="quoteWizard({{ json_encode($aiConfig) }})">
                        <form
                            method="POST"
                            action="{{ route('quote.step.store', [$session->uuid, $step_key]) }}"
                            novalidate
                            data-track="quote:step"
                        >
                            @csrf
                            <input type="hidden" name="session_id" value="{{ $session_id }}">

                            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-dark-card sm:p-8">
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $step['label'] ?? 'Your Project' }}
                                </h1>

                                @if (! empty($step['description']))
                                    <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                        {{ $step['description'] }}
                                    </p>
                                @endif

                                <div class="mt-8 space-y-7">
                                    @foreach ($questions as $question)
                                        @if ($question['ai_enabled'] ?? null === 'description')
                                            <div>
                                                @include('quote.components.question', ['question' => $question, 'answers' => $answers])

                                                @if ($ai_available)
                                                    <button
                                                        type="button"
                                                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 transition hover:text-primary-700"
                                                        @click="improveDescription()"
                                                        :disabled="busy"
                                                        data-track="quote:ai:improve"
                                                    >
                                                        <x-icon name="sparkles" class="h-4 w-4" />
                                                        <span x-text="busy ? 'Improving your description…' : 'Improve this description with AI'"></span>
                                                    </button>

                                                    <div x-show="improvedDescription" x-cloak class="mt-4 rounded-xl border border-primary-200 bg-primary-50/60 p-4 text-sm dark:border-primary-500/30 dark:bg-primary-500/10">
                                                        <p class="font-semibold text-primary-700 dark:text-primary-300">AI suggested description</p>
                                                        <p class="mt-1 leading-relaxed text-gray-700 dark:text-gray-300" x-text="improvedDescription"></p>

                                                        <div x-show="clarifyingQuestions.length" class="mt-3">
                                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Questions worth answering</p>
                                                            <ul class="mt-1 list-inside list-disc space-y-1 text-gray-600 dark:text-gray-400">
                                                                <template x-for="question in clarifyingQuestions" :key="question">
                                                                    <li x-text="question"></li>
                                                                </template>
                                                            </ul>
                                                        </div>

                                                        <button
                                                            type="button"
                                                            class="mt-3 inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-primary-700"
                                                            @click="applyImprovedDescription()"
                                                        >
                                                            Use this version
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif ($question['ai_enabled'] ?? null === 'features')
                                            <div>
                                                @include('quote.components.question', ['question' => $question, 'answers' => $answers])

                                                @if ($ai_available)
                                                    <button
                                                        type="button"
                                                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 transition hover:text-primary-700"
                                                        @click="suggestFeatures()"
                                                        :disabled="busy"
                                                        data-track="quote:ai:suggest"
                                                    >
                                                        <x-icon name="sparkles" class="h-4 w-4" />
                                                        <span x-text="busy ? 'Thinking of relevant features…' : 'Suggest relevant features with AI'"></span>
                                                    </button>

                                                    <div x-show="suggestions.length" x-cloak class="mt-4 space-y-2">
                                                        <template x-for="suggestion in suggestions" :key="suggestion.key">
                                                            <button
                                                                type="button"
                                                                class="flex w-full items-start gap-3 rounded-xl border border-primary-200 bg-white px-4 py-3 text-left text-sm transition hover:border-primary-500 dark:border-primary-500/30 dark:bg-dark-card"
                                                                @click="toggleSuggestion(suggestion.key)"
                                                                data-track="quote:ai:suggestion:apply"
                                                            >
                                                                <span class="flex-none rounded-md bg-primary-100 p-1 text-primary-600 dark:bg-primary-500/20 dark:text-primary-300">
                                                                    <x-icon name="star" class="h-4 w-4" />
                                                                </span>
                                                                <span>
                                                                    <span class="block font-semibold text-gray-900 dark:text-white" x-text="suggestion.key"></span>
                                                                    <span class="block text-xs text-gray-500" x-text="suggestion.reason"></span>
                                                                </span>
                                                            </button>
                                                        </template>
                                                        <p class="text-xs text-gray-500">Tap a suggestion to select or deselect it.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            @include('quote.components.question', ['question' => $question, 'answers' => $answers])
                                        @endif
                                    @endforeach
                                </div>
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

                                <div class="flex flex-wrap items-center gap-3">
                                    <x-buttons.button
                                        variant="secondary"
                                        :href="route('quote.show', [$session->uuid, 'step' => $step_key])"
                                        display="hidden sm:inline-flex"
                                    >
                                        Save &amp; continue later
                                    </x-buttons.button>

                                    <x-buttons.button type="submit" class="w-full sm:w-auto">
                                        {{ $next_step ? 'Continue' : 'Review My Answers' }}
                                        <x-icon name="arrow-right" class="h-4 w-4" />
                                    </x-buttons.button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="lg:sticky lg:top-24 lg:self-start">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-dark-card">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white">Need a hand?</h2>
                        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-3">
                                <x-icon name="shield-check" class="mt-0.5 h-5 w-5 flex-none text-primary-600" />
                                <span>Your answers are only used to prepare your quote. We never share your details.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <x-icon name="clock" class="mt-0.5 h-5 w-5 flex-none text-primary-600" />
                                <span>This takes about 2-3 minutes. You can save and continue later.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <x-icon name="chat-bubble-left-right" class="mt-0.5 h-5 w-5 flex-none text-primary-600" />
                                <span>Prefer to talk first?
                                    <a href="{{ route('contact') }}" class="font-semibold text-primary-600 hover:text-primary-700">Contact us</a>.
                                </span>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>
