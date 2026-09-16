<x-layouts.admin-portal :title="'Portfolio Projects'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">Portfolio Projects</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Projects shown on the public portfolio page.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.portfolio.categories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                Categories
            </a>
            @if (auth('admin')->user()->hasPermission('portfolio.create'))
                <a href="{{ route('admin.portfolio.create') }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                    Add project
                </a>
            @endif
        </div>
    </div>

    <form method="GET" action="{{ route('admin.portfolio.index') }}" class="mb-6 flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search by title or slug"
            class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
        <select name="category" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="published" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All statuses</option>
            <option value="yes" {{ request('published') === 'yes' ? 'selected' : '' }}>Published</option>
            <option value="no" {{ request('published') === 'no' ? 'selected' : '' }}>Unpublished</option>
        </select>
        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Filter</button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($projects->isEmpty())
            <p class="p-6 text-sm text-slate-500">No projects found. Add your first portfolio project to replace the built-in samples.</p>
        @else
            <table class="w-full min-w-[720px] text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Featured</th>
                        <th class="px-4 py-3">Published</th>
                        <th class="px-4 py-3">Sort</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3">
                                <span class="font-medium text-primary-600">{{ $project->title }}</span>
                                <p class="text-xs text-slate-500">/{{ $project->slug }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $project->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $project->status }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $project->featured ? 'bg-primary-500/10 text-primary-700 dark:text-primary-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800' }}">
                                    {{ $project->featured ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $project->is_published ? 'bg-success-500/10 text-success-700 dark:text-success-500' : 'bg-error-500/10 text-error-700 dark:text-error-500' }}">
                                    {{ $project->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $project->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if (auth('admin')->user()->hasPermission('portfolio.publish'))
                                        <form method="POST" action="{{ route('admin.portfolio.publish', $project) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg px-2 py-1 text-xs font-medium hover:bg-slate-100 dark:hover:bg-slate-800">
                                                {{ $project->is_published ? 'Unpublish' : 'Publish' }}
                                            </button>
                                        </form>
                                    @endif
                                    @if (auth('admin')->user()->hasPermission('portfolio.update'))
                                        <a href="{{ route('admin.portfolio.edit', $project) }}" class="rounded-lg px-2 py-1 text-xs font-medium text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-600/15">Edit</a>
                                    @endif
                                    @if (auth('admin')->user()->hasPermission('portfolio.delete'))
                                        <form method="POST" action="{{ route('admin.portfolio.destroy', $project) }}" onsubmit="return confirm('Delete this project permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg px-2 py-1 text-xs font-medium text-error-600 hover:bg-error-500/10 dark:text-error-400">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</x-layouts.admin-portal>
