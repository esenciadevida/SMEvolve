@props([
    'permissionGroups' => [],
    'selected' => [],
    'showCounts' => true,
])

@php
    $total = collect($permissionGroups)->flatten(1)->count();
    $current = collect($selected)->map(fn ($key) => (string) $key)->flip();
    $riskTones = ['low' => 'success', 'medium' => 'warning', 'high' => 'error'];
    $riskLabels = ['low' => 'Low risk', 'medium' => 'Medium risk', 'high' => 'High risk'];
@endphp

<div x-data="{ total: {{ $total }}, count: {{ $current->count() }} }">
    @if ($showCounts)
        <div class="mb-4 flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-900">
            <span class="text-slate-600 dark:text-slate-300">Permissions granted</span>
            <span class="font-semibold" x-text="`${count} of ${total}`">0 of 0</span>
        </div>
    @endif

    <div class="space-y-4">
        @foreach ($permissionGroups as $groupLabel => $permissions)
            <fieldset class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <legend class="sr-only">{{ $groupLabel }} permissions</legend>

                <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-3 dark:border-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $groupLabel }}</p>
                    <label class="flex cursor-pointer items-center gap-2 text-xs text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                        <input
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                            x-on:change="document.querySelectorAll('[data-permission-group=&quot;{{ $groupLabel }}&quot;]').forEach(cb => { cb.checked = $el.checked; })"
                        >
                        Select all
                    </label>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($permissions as $permission)
                        @php
                            $checked = $current->has($permission['key']);
                            $tone = $riskTones[$permission['risk']] ?? 'slate';
                        @endphp
                        <label class="flex cursor-pointer items-start gap-3 px-4 py-3 transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission['key'] }}"
                                data-permission-group="{{ $groupLabel }}"
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                                @checked($checked)
                                x-on:change="count += $el.checked ? 1 : -1"
                            >
                            <span class="min-w-0 flex-1">
                                <span class="flex flex-wrap items-center gap-2">
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $permission['label'] }}</span>
                                    <x-admin.badge :tone="$tone">{{ $riskLabels[$permission['risk']] ?? 'Unknown risk' }}</x-admin.badge>
                                </span>
                                <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">{{ $permission['description'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        @endforeach
    </div>
</div>
