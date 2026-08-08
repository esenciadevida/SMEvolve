<x-layouts.admin-portal :title="'Quote '.$quote->reference">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.quotes.index') }}" class="text-xs text-primary-600 hover:underline">← Back to quotes</a>
            <h1 class="mt-1 text-xl font-semibold">Quote {{ $quote->reference }}</h1>
        </div>

        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600 dark:bg-slate-800 dark:text-slate-300">
            {{ $statuses[$quote->status] ?? $quote->status }}
        </span>
    </div>

    @if ($canUpdateStatus)
        <form method="POST" action="{{ route('admin.quotes.status', $quote) }}" class="mb-6 flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @csrf
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" {{ $quote->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Update status</button>
        </form>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Contact Details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Name</dt>
                    <dd class="font-medium">{{ $quote->contact_name }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Email</dt>
                    <dd class="font-medium">{{ $quote->contact_email }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Phone</dt>
                    <dd class="font-medium">{{ $quote->contact_phone ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Preferred contact</dt>
                    <dd class="font-medium">{{ $quote->preferred_contact_method ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Submitted</dt>
                    <dd class="font-medium">{{ optional($quote->submitted_at)->format('M j, Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Project Details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Project type</dt>
                    <dd class="font-medium">{{ $quote->quoteSession?->project_type ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Business</dt>
                    <dd class="font-medium">{{ $quote->quoteSession?->business_name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Industry</dt>
                    <dd class="font-medium">{{ $quote->quoteSession?->industry ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Budget</dt>
                    <dd class="font-medium">{{ $quote->quoteSession?->budget_range ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Timeline</dt>
                    <dd class="font-medium">{{ $quote->quoteSession?->timeline ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if (filled($quote->quoteSession?->description))
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Project Description</h2>
            <p class="mt-3 whitespace-pre-line text-sm text-slate-600 dark:text-slate-300">{{ $quote->quoteSession->description }}</p>
        </div>
    @endif

    @if (filled($quote->snapshot))
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Session Snapshot</h2>
            <pre class="mt-3 overflow-x-auto text-xs text-slate-600 dark:text-slate-300">{{ json_encode($quote->snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
        </div>
    @endif

    @if ($quote->consents->isNotEmpty())
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Consents</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($quote->consents as $consent)
                    <li class="flex items-center gap-2">
                        <span class="{{ $consent->accepted ? 'text-success-600' : 'text-error-600' }}">
                            {{ $consent->accepted ? '✓' : '✗' }}
                        </span>
                        <span>{{ $consent->consent_type }} {{ $consent->document }}</span>
                        <span class="text-xs text-slate-500">{{ optional($consent->accepted_at)->format('M j, Y') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layouts.admin-portal>
