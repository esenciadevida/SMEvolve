<x-layouts.admin :title="'Configuration'">
    <div class="max-w-3xl">
        <h1 class="text-xl font-bold">Configuration</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Feature toggles and messages stored in the database. Environment-level values (provider, API keys, limits) are managed in the <code>.env</code> file.</p>

        <form method="POST" action="{{ route('admin.ai.config.update') }}" class="mt-6 space-y-6">
            @csrf

            <div class="space-y-4 rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Feature Toggles</h2>

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

                <div>
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
            </div>

            <div class="space-y-4 rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Messages</h2>

                <div>
                    <label for="welcome_message" class="block text-sm font-medium">Welcome Message</label>
                    <textarea
                        id="welcome_message"
                        name="values[assistant.welcome_message]"
                        rows="3"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                    >{{ $values['assistant.welcome_message'] }}</textarea>
                </div>

                <div>
                    <label for="availability_message" class="block text-sm font-medium">Availability Message</label>
                    <textarea
                        id="availability_message"
                        name="values[assistant.availability_message]"
                        rows="3"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                    >{{ $values['assistant.availability_message'] }}</textarea>
                </div>
            </div>

            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save configuration
            </button>
        </form>
    </div>
</x-layouts.admin>
