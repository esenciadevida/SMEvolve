@props(['result' => []])

@php
    $icons = [
        'quote' => 'clipboard-document-list',
        'administrator' => 'user-circle',
        'setting' => 'swatch',
        'knowledge' => 'academic-cap',
        'audit_log' => 'activity',
    ];

    $statusTones = [
        'submitted' => 'primary',
        'under_review' => 'warning',
        'quoted' => 'info',
        'completed' => 'success',
        'cancelled' => 'error',
        'published' => 'success',
        'draft' => 'warning',
    ];

    $badgeLabel = null;
    $badgeTone = 'slate';

    if (isset($result['metadata']['status'])) {
        $badgeLabel = $result['metadata']['status'];
        $badgeTone = $statusTones[$result['metadata']['status_key'] ?? null] ?? 'slate';
    } elseif (isset($result['metadata']['role'])) {
        $badgeLabel = $result['metadata']['role'];
    } elseif (isset($result['metadata']['group'])) {
        $badgeLabel = ucfirst($result['metadata']['group']);
        $badgeTone = 'info';
    }
@endphp

<a
    href="{{ $result['url'] }}"
    class="group flex items-start gap-3 rounded-xl px-3 py-3 transition hover:bg-slate-50 dark:hover:bg-slate-800/50"
>
    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <x-icon :name="$icons[$result['type']] ?? 'magnifying-glass'" class="h-4 w-4" />
    </span>

    <span class="min-w-0 flex-1">
        <span class="block truncate text-sm font-medium text-slate-900 transition group-hover:text-primary-600 dark:text-slate-100 dark:group-hover:text-primary-400">{{ $result['title'] }}</span>
        <span class="block truncate text-xs text-slate-500 dark:text-slate-400">{{ $result['subtitle'] }}</span>
    </span>

    @if ($badgeLabel)
        <span class="mt-0.5 shrink-0">
            <x-admin.badge :tone="$badgeTone">{{ $badgeLabel }}</x-admin.badge>
        </span>
    @endif

    <x-icon name="arrow-up-right" class="mt-1 h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-primary-500 dark:text-slate-600 dark:group-hover:text-primary-400" />
</a>
