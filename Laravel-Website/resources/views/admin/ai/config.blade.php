<x-layouts.admin-portal :title="'AI Configuration'">
    <x-admin.page-header title="Configuration" subtitle="Feature toggles and messages stored in the database. Environment-level values (provider, API keys, limits) are managed in the .env file." />

    @unless ($globalEnabled)
        <div class="mt-6 max-w-3xl rounded-xl border border-warning-500/30 bg-warning-500/10 px-4 py-3 text-sm text-warning-700 dark:text-warning-400">
            <strong>Global AI switch is off.</strong> The global toggle (on the <a href="{{ route('admin.ai.settings') }}" class="underline">AI Settings</a> page) is currently off, so the toggles below are saved but the assistant will not appear until the global switch is enabled.
        </div>
    @endunless

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.ai.config.update') }}" class="mt-6 space-y-6">
            @csrf

            <x-admin.card title="Feature Toggles">
                <div>
                    <label class="flex items-center justify-between gap-4 text-sm">
                        <span>Website Assistant</span>
                        <input
                            type="hidden" name="values[assistant.enabled]" value="0">
                        <input
                            type="checkbox"
                            name="values[assistant.enabled]"
                            value="1"
                            class="h-5 w-5 rounded border-slate-300 accent-primary-600 dark:border-slate-700"
                            {{ $values['assistant.enabled'] ? 'checked' : '' }}
                        >
                    </label>
                </div>

                <div class="mt-4">
                    <label class="flex items-center justify-between gap-4 text-sm">
                        <span>Quote Wizard AI</span>
                        <input
                            type="hidden" name="values[quote.enabled]" value="0">
                        <input
                            type="checkbox"
                            name="values[quote.enabled]"
                            value="1"
                            class="h-5 w-5 rounded border-slate-300 accent-primary-600 dark:border-slate-700"
                            {{ $values['quote.enabled'] ? 'checked' : '' }}
                        >
                    </label>
                </div>
            </x-admin.card>

            <x-admin.card title="Messages">
                <div>
                    <label for="welcome_message" class="block text-sm font-medium">Welcome Message</label>
                    <textarea
                        id="welcome_message"
                        name="values[assistant.welcome_message]"
                        rows="3"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                    >{{ $values['assistant.welcome_message'] }}</textarea>
                </div>

                <div class="mt-4">
                    <label for="availability_message" class="block text-sm font-medium">Availability Message</label>
                    <textarea
                        id="availability_message"
                        name="values[assistant.availability_message]"
                        rows="3"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                    >{{ $values['assistant.availability_message'] }}</textarea>
                </div>
            </x-admin.card>

            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save configuration
            </button>
        </form>
    </div>
</x-layouts.admin-portal>
