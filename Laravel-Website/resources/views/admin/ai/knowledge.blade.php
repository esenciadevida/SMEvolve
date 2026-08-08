<x-layouts.admin :title="'Knowledge'">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h1 class="text-xl font-bold">Knowledge Base</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Curated knowledge items injected into AI responses alongside content from the website configuration (services, packages, FAQs, company info).</p>

            <form method="GET" action="{{ route('admin.ai.knowledge.index') }}" class="mt-4 flex flex-wrap items-center gap-2">
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

            <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                @if ($items->isEmpty())
                    <p class="p-5 text-sm text-slate-500 dark:text-slate-400">No knowledge items found.</p>
                @else
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
                                        @if ($item->status === 'published')
                                            <span class="rounded-full bg-success-500/15 px-2 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">Published</span>
                                        @elseif ($item->status === 'archived')
                                            <span class="rounded-full bg-slate-500/15 px-2 py-0.5 text-xs font-medium text-slate-600 dark:text-slate-400">Archived</span>
                                        @else
                                            <span class="rounded-full bg-warning-500/15 px-2 py-0.5 text-xs font-medium text-warning-700 dark:text-warning-500">Draft</span>
                                        @endif
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
                @endif
            </div>

            {{ $items->links() }}
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Add Knowledge Item</h2>
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
        </div>
    </div>
</x-layouts.admin>
