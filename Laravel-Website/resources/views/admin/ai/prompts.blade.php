<x-layouts.admin :title="'Prompts'">
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Prompt Management</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Each prompt profile has layered content: <code>global</code>, <code>business</code>, and the feature-specific prompt (<code>website_assistant</code>, <code>quote_assistant</code>).</p>
        </div>

        @foreach ($prompts as $prompt)
            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-sm font-semibold">{{ $prompt->name }}</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400"><code>{{ $prompt->key }}</code></p>
                        @if ($prompt->description)
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $prompt->description }}</p>
                        @endif
                    </div>
                    <span class="rounded-full bg-success-500/15 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">
                        v{{ $prompt->active_version_id ? \App\Models\AiPromptVersion::where('id', $prompt->active_version_id)->value('version') : '-' }}
                    </span>
                </div>

                <details class="mt-4">
                    <summary class="cursor-pointer text-xs font-medium text-primary-600 dark:text-primary-400">Versions ({{ $prompt->versions->count() }})</summary>

                    @if ($prompt->versions->isNotEmpty())
                        <div class="mt-3 space-y-2">
                            @foreach ($prompt->versions as $version)
                                <div class="flex items-center justify-between gap-4 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium">
                                            v{{ $version->version }}
                                            @if ($version->id === $prompt->active_version_id)
                                                <span class="ml-1 rounded-full bg-primary-600/15 px-2 py-0.5 text-xs text-primary-700 dark:text-primary-400">Active</span>
                                            @endif
                                        </p>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $version->status }} · {{ $version->created_at }}</p>
                                    </div>
                                    @if ($version->id !== $prompt->active_version_id && $version->status !== 'archived')
                                        <form method="POST" action="{{ route('admin.ai.prompts.versions.activate', [$prompt, $version]) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg border border-primary-600 px-3 py-1 text-xs font-medium text-primary-600 hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-slate-800">Activate</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No versions yet. The bundled markdown file is currently used as a fallback.</p>
                    @endif
                </details>

                <form method="POST" action="{{ route('admin.ai.prompts.versions.store', $prompt) }}" class="mt-4 rounded-lg border border-slate-200 p-4 dark:border-slate-700">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <label for="version-{{ $prompt->id }}" class="block text-xs font-medium">Version</label>
                            <input
                                type="text"
                                id="version-{{ $prompt->id }}"
                                name="version"
                                placeholder="1.0"
                                required
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                        <div class="sm:col-span-2">
                            <label for="content-{{ $prompt->id }}" class="block text-xs font-medium">Content</label>
                            <textarea
                                id="content-{{ $prompt->id }}"
                                name="content"
                                rows="4"
                                placeholder="Prompt content for this layer..."
                                required
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"
                            ></textarea>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-xs">
                            <input type="checkbox" name="activate" value="1" class="h-4 w-4 rounded border-slate-300 accent-primary-600">
                            Activate immediately
                        </label>
                        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-primary-700">Create version</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
