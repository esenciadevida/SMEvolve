<x-layouts.admin-portal :title="$title">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Website Settings</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
    </div>

    <div class="mb-6 flex flex-wrap gap-2 text-sm">
        @foreach (['general' => 'General', 'contact' => 'Contact', 'business' => 'Business', 'social' => 'Social'] as $key => $label)
            <a
                href="{{ route('admin.settings.index', ['group' => $key]) }}"
                class="rounded-lg px-3 py-1.5 {{ $group === $key ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.settings.update', ['group' => $group]) }}" x-data="{ submitting: false }" x-on:submit="submitting = true" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf
        @include('admin.website._fields')

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" :disabled="submitting" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60">
                Save changes
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
