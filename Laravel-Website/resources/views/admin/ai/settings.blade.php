<x-layouts.admin-portal :title="'AI Settings'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">AI Settings</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Configure the AI provider used across the website.</p>
    </div>

    @if (! $canUpdate)
        <div class="mb-4 rounded-lg border border-warning-500/30 bg-warning-500/10 px-4 py-3 text-sm text-warning-700 dark:text-warning-500">
            Your role does not have permission to change AI settings.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.ai.update') }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-4 dark:border-slate-800">
            <div>
                <p class="text-sm font-medium">Enable AI</p>
                <p class="mt-1 text-xs text-slate-500">Global switch for all AI-powered features.</p>
            </div>
            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="enabled" value="1" class="peer sr-only" {{ $enabled ? 'checked' : '' }} {{ ! $canUpdate ? 'disabled' : '' }}>
                <span class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:transition peer-checked:bg-primary-600 peer-checked:after:translate-x-5 dark:bg-slate-700"></span>
            </label>
        </div>

        <div>
            <label for="model" class="block text-sm font-medium">Model</label>
            <select
                id="model"
                name="model"
                {{ ! $canUpdate ? 'disabled' : '' }}
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
                @foreach ($approved_models as $key => $label)
                    <option value="{{ $key }}" {{ $model === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="max_output_tokens" class="block text-sm font-medium">Max output tokens</label>
                <input
                    type="number"
                    id="max_output_tokens"
                    name="max_output_tokens"
                    value="{{ old('max_output_tokens', $max_output_tokens) }}"
                    min="128"
                    max="4096"
                    {{ ! $canUpdate ? 'disabled' : '' }}
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>

            <div>
                <label for="temperature" class="block text-sm font-medium">Temperature</label>
                <input
                    type="number"
                    id="temperature"
                    name="temperature"
                    value="{{ old('temperature', $temperature) }}"
                    step="0.1"
                    min="0"
                    max="1"
                    {{ ! $canUpdate ? 'disabled' : '' }}
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            @if ($canUpdate)
                <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                    Save changes
                </button>
            @endif
        </div>
    </form>
</x-layouts.admin-portal>
