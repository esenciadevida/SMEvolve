<x-layouts.admin-portal :title="'Add Project'">
    <div class="mb-6">
        <a href="{{ route('admin.portfolio.index') }}" class="text-xs text-primary-600 hover:underline">← Back to projects</a>
        <h1 class="mt-1 text-xl font-semibold">Add Project</h1>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.store') }}" class="max-w-3xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        @include('admin.portfolio._form', ['project' => null])

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.portfolio.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Create project
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
