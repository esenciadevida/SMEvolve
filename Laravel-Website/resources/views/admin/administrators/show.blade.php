<x-layouts.admin-portal :title="$administrator->name">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.administrators.index') }}" class="text-xs text-primary-600 hover:underline">← Back to administrators</a>
            <h1 class="mt-1 text-xl font-semibold">{{ $administrator->name }}</h1>
            <p class="text-sm text-slate-500">{{ $administrator->email }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($canUpdate)
                <a href="{{ route('admin.administrators.edit', $administrator) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Edit</a>
            @endif

            @if ($canDisable && $administrator->is_active)
                <form method="POST" action="{{ route('admin.administrators.disable', $administrator) }}" onsubmit="return confirm('Disable this administrator?');">
                    @csrf
                    <button type="submit" class="rounded-lg bg-error-600 px-4 py-2 text-sm font-semibold text-white hover:bg-error-700">Disable</button>
                </form>
            @endif

            @if ($canDisable && ! $administrator->is_active)
                <form method="POST" action="{{ route('admin.administrators.enable', $administrator) }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-success-600 px-4 py-2 text-sm font-semibold text-white hover:bg-success-700">Enable</button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Role</dt>
                    <dd class="font-medium">{{ $administrator->role?->label }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Status</dt>
                    <dd class="font-medium">{{ $administrator->is_active ? 'Active' : 'Disabled' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Last login</dt>
                    <dd class="font-medium">{{ optional($administrator->last_login_at)->diffForHumans() ?? 'Never' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Last login IP</dt>
                    <dd class="font-medium">{{ $administrator->last_login_ip ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Member since</dt>
                    <dd class="font-medium">{{ $administrator->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold">Role Permissions</h2>
            <ul class="mt-4 flex flex-wrap gap-2">
                @forelse ($administrator->role?->permissions ?? [] as $permission)
                    <li class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ config('admin_permissions')[$permission]['label'] ?? 'Assigned permission' }}</li>
                @empty
                    <li class="text-sm text-slate-500">No permissions assigned.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layouts.admin-portal>
