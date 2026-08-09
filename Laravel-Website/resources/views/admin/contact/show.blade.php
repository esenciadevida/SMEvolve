<x-layouts.admin-portal :title="'Contact Message'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.contact.index') }}" class="text-sm text-primary-600 hover:underline">&larr; Back to messages</a>
            <h1 class="mt-2 text-xl font-semibold">{{ $message->subjectLabel() }}</h1>
        </div>
    </div>

    <div class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-2 dark:border-slate-800 dark:bg-slate-900">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">From</p>
            <p class="mt-1 text-sm font-medium">{{ $message->name }}</p>
            <p class="text-sm text-slate-600 dark:text-slate-300">{{ $message->email }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Company</p>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $message->company ?? 'Not supplied' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Phone</p>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $message->phone ?? 'Not supplied' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Received</p>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ optional($message->created_at)->format('M j, Y H:i') }}</p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Message</p>
        <p class="mt-3 whitespace-pre-wrap text-sm leading-relaxed text-slate-800 dark:text-slate-200">{{ $message->message }}</p>
    </div>
</x-layouts.admin-portal>
