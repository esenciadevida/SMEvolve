<x-layouts.admin-portal :title="'Chatbot'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Chatbot Assistant</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Control the AI assistant that greets visitors and answers questions.</p>
    </div>

    <form method="POST" action="{{ route('admin.chatbot.update') }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-4 dark:border-slate-800">
            <div>
                <p class="text-sm font-medium">Enable chatbot</p>
                <p class="mt-1 text-xs text-slate-500">Show the AI assistant to website visitors.</p>
            </div>
            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="enabled" value="1" class="peer sr-only" {{ $enabled ? 'checked' : '' }}>
                <span class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:transition peer-checked:bg-primary-600 peer-checked:after:translate-x-5 dark:bg-slate-700"></span>
            </label>
        </div>

        <div>
            <label for="welcome_message" class="block text-sm font-medium">Welcome message</label>
            <textarea
                id="welcome_message"
                name="welcome_message"
                rows="3"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >{{ old('welcome_message', $welcome_message) }}</textarea>
        </div>

        <div>
            <label for="availability_message" class="block text-sm font-medium">Availability message</label>
            <textarea
                id="availability_message"
                name="availability_message"
                rows="2"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >{{ old('availability_message', $availability_message) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save changes
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
