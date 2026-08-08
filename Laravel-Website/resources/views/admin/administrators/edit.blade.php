<x-layouts.admin-portal :title="'Edit '.$administrator->name">
    <div class="mb-6">
        <a href="{{ route('admin.administrators.show', $administrator) }}" class="text-xs text-primary-600 hover:underline">← Back to {{ $administrator->name }}</a>
        <h1 class="mt-1 text-xl font-semibold">Edit Administrator</h1>
    </div>

    <form method="POST" action="{{ route('admin.administrators.update', $administrator) }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $administrator->name) }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $administrator->email) }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="role_id" class="block text-sm font-medium">Role</label>
            @if ($canChangeRole)
                <select
                    id="role_id"
                    name="role_id"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ (int) old('role_id', $administrator->role_id) === (int) $role->id ? 'selected' : '' }}>{{ $role->label }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="role_id" value="{{ $administrator->role_id }}">
                <p class="mt-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-800 dark:bg-slate-900">{{ $administrator->role?->label }}</p>
            @endif
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.administrators.show', $administrator) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save changes
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
