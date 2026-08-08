<x-layouts.admin-portal :title="'Portfolio Categories'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">Portfolio Categories</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Categories used to group portfolio projects.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.portfolio.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                Projects
            </a>
            @if (auth('admin')->user()->hasPermission('portfolio.create'))
                <a href="{{ route('admin.portfolio.categories.create') }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                    Add category
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($categories->isEmpty())
            <p class="p-6 text-sm text-slate-500">No categories yet. Create a category before adding projects.</p>
        @else
            <table class="w-full text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Projects</th>
                        <th class="px-4 py-3">Published</th>
                        <th class="px-4 py-3">Sort</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">/{{ $category->slug }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $category->projects_count }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $category->is_published ? 'bg-success-500/10 text-success-700 dark:text-success-500' : 'bg-error-500/10 text-error-700 dark:text-error-500' }}">
                                    {{ $category->is_published ? 'Published' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $category->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if (auth('admin')->user()->hasPermission('portfolio.update'))
                                        <a href="{{ route('admin.portfolio.categories.edit', $category) }}" class="rounded-lg px-2 py-1 text-xs font-medium text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-600/15">Edit</a>
                                    @endif
                                    @if (auth('admin')->user()->hasPermission('portfolio.delete'))
                                        <form method="POST" action="{{ route('admin.portfolio.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Projects in it will become uncategorised.')">
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
</x-layouts.admin-portal>
