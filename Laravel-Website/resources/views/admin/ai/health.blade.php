<x-layouts.admin-portal :title="'AI Health'">
    <x-admin.page-header title="Health & Configuration" subtitle="Runtime status of the AI system. Provider credentials and keys are never displayed." />

    <div class="max-w-3xl space-y-6">
        <x-admin.card title="Provider">
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Name</dt><dd class="font-medium">{{ $providerName }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Model</dt><dd class="font-medium">{{ $model }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Base URL</dt><dd class="font-medium">{{ $baseUrl }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Timeout</dt><dd class="font-medium">{{ $timeout }}s</dd></div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Configured</dt>
                    <dd>
                        <x-admin.badge :tone="$providerConfigured ? 'success' : 'error'" dot>{{ $providerConfigured ? 'Yes' : 'No' }}</x-admin.badge>
                    </dd>
                </div>
            </dl>
        </x-admin.card>

        <x-admin.card title="Features">
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Website Assistant</dt>
                    <dd>
                        <x-admin.badge :tone="$assistantEnabled ? 'success' : 'slate'" dot>{{ $assistantEnabled ? 'Enabled' : 'Disabled' }}</x-admin.badge>
                    </dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500 dark:text-slate-400">Quote Wizard AI</dt>
                    <dd>
                        <x-admin.badge :tone="$quoteEnabled ? 'success' : 'slate'" dot>{{ $quoteEnabled ? 'Enabled' : 'Disabled' }}</x-admin.badge>
                    </dd>
                </div>
            </dl>
        </x-admin.card>

        <x-admin.card title="Limits">
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max message length</dt><dd>{{ $limits['max_message_length'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max context messages</dt><dd>{{ $limits['max_context_messages'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Max requests per session</dt><dd>{{ $limits['max_requests_per_session'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Conversation retention</dt><dd>{{ $limits['conversation_retention_days'] }} days</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Message rate limit</dt><dd>{{ $rateLimits['send_message'] }} / {{ $rateLimits['decay_minutes'] }}min</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-slate-500 dark:text-slate-400">Quote analyze rate limit</dt><dd>{{ $rateLimits['quote_analyze'] }} / {{ $rateLimits['decay_minutes'] }}min</dd></div>
            </dl>
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
