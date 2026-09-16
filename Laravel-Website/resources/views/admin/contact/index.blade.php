<x-layouts.admin-portal :title="'Contact Messages'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Contact Messages</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Enquiries submitted through the website contact form.</p>
    </div>

    <form method="GET" action="{{ route('admin.contact.index') }}" class="mb-6 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4 dark:border-slate-800 dark:bg-slate-900">
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All statuses</option>
            <option value="unread" {{ $status === 'unread' ? 'selected' : '' }}>Unread</option>
            <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Read</option>
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Filter</button>
            <a href="{{ route('admin.contact.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($messages->isEmpty())
            <p class="p-6 text-sm text-slate-500">No messages found.</p>
        @else
            <table class="w-full min-w-[640px] text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">From</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Received</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($messages as $message)
                        <tr class="{{ $message->is_read ? '' : 'font-medium' }} hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.contact.show', $message) }}" class="text-primary-600 hover:underline">{{ $message->name }}</a>
                                <p class="text-xs font-normal text-slate-500">{{ $message->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $message->subjectLabel() }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $message->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ optional($message->created_at)->format('M j, Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</x-layouts.admin-portal>
