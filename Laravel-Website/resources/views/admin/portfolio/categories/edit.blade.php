<x-layouts.admin-portal :title="'Edit Category'">
    <div class="mb-6">
        <a href="{{ route('admin.portfolio.categories.index') }}" class="text-xs text-primary-600 hover:underline">← Back to categories</a>
        <h1 class="mt-1 text-xl font-semibold">Edit Category</h1>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.categories.update', $category) }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf
        @method('PUT')

        @include('admin.portfolio.categories._form', ['category' => $category])

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.portfolio.categories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Update category
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
