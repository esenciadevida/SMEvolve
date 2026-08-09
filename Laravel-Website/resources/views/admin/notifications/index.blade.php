<x-layouts.admin-portal :title="'Notifications'">
    <x-admin.page-header title="Notifications" subtitle="Choose which security notifications you receive by email." />

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.notifications.update') }}" class="space-y-4">
                @csrf

                <x-admin.card title="Email notifications" subtitle="Critical security events are always sent and cannot be disabled.">
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($events as $event => $meta)
                            <div class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $meta['label'] }}
                                        @if ($meta['critical'])
                                            <x-admin.badge tone="error" class="ml-2">Always sent</x-admin.badge>
                                        @endif
                                    </p>
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $meta['description'] }}</p>
                                </div>
                                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                                    <input
                                        type="checkbox"
                                        name="events[]"
                                        value="{{ $event }}"
                                        class="peer sr-only"
                                        {{ ($preferences[$event] ?? false) ? 'checked' : '' }}
                                        {{ $meta['critical'] ? 'disabled' : '' }}
                                    >
                                    <span class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:transition peer-checked:bg-primary-600 peer-checked:after:translate-x-5 dark:bg-slate-700"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex justify-end border-t border-slate-100 pt-4 dark:border-slate-800">
                        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                            Save preferences
                        </button>
                    </div>
                </x-admin.card>
            </form>
        </div>

        <div class="space-y-6">
            <x-admin.card title="Recent notifications" subtitle="Latest deliveries">
                @if ($recentNotifications->isEmpty())
                    <p class="py-8 text-center text-sm text-slate-400 dark:text-slate-500">No notifications sent yet.</p>
                @else
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($recentNotifications as $notification)
                            <li class="flex items-start justify-between gap-3 py-3 first:pt-0 last:pb-0">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">{{ $notification->subject }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $notification->event }} &middot; {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <x-admin.badge
                                    :tone="$notification->status === 'sent' ? 'success' : ($notification->status === 'failed' ? 'error' : 'slate')"
                                    dot
                                >
                                    {{ $notification->status }}
                                </x-admin.badge>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.card>
        </div>
    </div>
</x-layouts.admin-portal>
