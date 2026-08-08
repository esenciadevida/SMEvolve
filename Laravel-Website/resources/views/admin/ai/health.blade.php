<x-layouts.admin :title="'Health'">
    <div class="max-w-3xl space-y-6">
        <div>
            <h1 class="text-xl font-bold">Health & Configuration</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Runtime status of the AI system. Provider credentials and keys are never displayed.</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Provider</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Name</dt><dd class="font-medium">{{ $providerName }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Model</dt><dd class="font-medium">{{ $model }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Base URL</dt><dd class="font-medium">{{ $baseUrl }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Timeout</dt><dd class="font-medium">{{ $timeout }}s</dd></div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Configured</dt>
                    <dd>
                        @if ($providerConfigured)
                            <span class="rounded-full bg-success-500/15 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">Yes</span>
                        @else
                            <span class="rounded-full bg-error-500/15 px-2.5 py-0.5 text-xs font-medium text-error-700 dark:text-error-500">No</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Features</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Website Assistant</dt>
                    <dd>{{ $assistantEnabled ? 'Enabled' : 'Disabled' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Quote Wizard AI</dt>
                    <dd>{{ $quoteEnabled ? 'Enabled' : 'Disabled' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Admin Console</dt>
                    <dd>{{ $adminEnabled ? 'Enabled' : 'Disabled' }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Limits</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max message length</dt><dd>{{ $limits['max_message_length'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max context messages</dt><dd>{{ $limits['max_context_messages'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max requests per session</dt><dd>{{ $limits['max_requests_per_session'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Conversation retention</dt><dd>{{ $limits['conversation_retention_days'] }} days</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Message rate limit</dt><dd>{{ $rateLimits['send_message'] }} / {{ $rateLimits['decay_minutes'] }}min</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Quote analyze rate limit</dt><dd>{{ $rateLimits['quote_analyze'] }} / {{ $rateLimits['decay_minutes'] }}min</dd></div>
            </dl>
        </div>
    </div>
</x-layouts.admin>
