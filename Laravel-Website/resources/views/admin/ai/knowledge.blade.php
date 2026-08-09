<x-layouts.admin-portal :title="'AI Knowledge Base'">
    <x-admin.page-header title="Knowledge Base" subtitle="Curated knowledge items injected into AI responses alongside content from the website configuration (services, packages, FAQs, company info)." />

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form method="GET" action="{{ route('admin.ai.knowledge.index') }}" class="flex flex-wrap items-center gap-2">
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search title or content..."
                    class="w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"
                >
                <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                    <option value="">All statuses</option>
                    @foreach (['draft', 'published', 'archived'] as $status)
                        <option value="{{ $status }}" @selected($statusFilter === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700">Filter</button>
            </form>

            <x-admin.card class="mt-4">
                @if ($items->isEmpty())
                    <p class="p-5 text-sm text-slate-500 dark:text-slate-400">No knowledge items found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Title</th>
                                    <th class="px-4 py-3 font-medium">Type</th>
                                    <th class="px-4 py-3 font-medium">Status</th>
                                    <th class="px-4 py-3 font-medium">Priority</th>
                                    <th class="px-4 py-3 font-medium"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <p class="font-medium">{{ $item->title }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ Str::limit($item->content, 60) }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $item->type }}</td>
                                        <td class="px-4 py-3">
                                            <x-admin.badge :tone="$item->status === 'published' ? 'success' : ($item->status === 'archived' ? 'slate' : 'warning')">
                                                {{ ucfirst($item->status) }}
                                            </x-admin.badge>
                                        </td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $item->priority }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <form method="POST" action="{{ route('admin.ai.knowledge.destroy', $item) }}" onsubmit="return confirm('Delete this knowledge item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-error-600 hover:text-error-700 dark:text-error-500">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{ $items->links() }}
            </x-admin.card>
        </div>

        <x-admin.card title="Add Knowledge Item">
            <form method="POST" action="{{ route('admin.ai.knowledge.store') }}" class="mt-4 space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-medium">Type</label>
                    <select name="type" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                        @foreach (['service', 'package', 'faq', 'company', 'custom'] as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium">Title</label>
                    <input type="text" name="title" required maxlength="200" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-medium">Content</label>
                    <textarea name="content" rows="4" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium">Keywords (comma separated)</label>
                    <input type="text" name="keywords_input" placeholder="pricing, website, seo" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium">Status</label>
                        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                            @foreach (['draft', 'published', 'archived'] as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Priority</label>
                        <select name="priority" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
                            @foreach (['low', 'normal', 'high'] as $priority)
                                <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Add item</button>
            </form>
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
