@php
    $c = $category ?? null;
@endphp

<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $c?->name) }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium">Slug</label>
            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $c?->slug) }}"
                placeholder="e.g. custom-software"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
    </div>

    <div>
        <label for="icon" class="block text-sm font-medium">Icon</label>
        <input
            type="text"
            id="icon"
            name="icon"
            value="{{ old('icon', $c?->icon) }}"
            placeholder="e.g. rectangle-stack"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
    </div>

    <div>
        <label for="description" class="block text-sm font-medium">Description</label>
        <textarea
            id="description"
            name="description"
            rows="3"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >{{ old('description', $c?->description) }}</textarea>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="sort_order" class="block text-sm font-medium">Sort order</label>
            <input
                type="number"
                id="sort_order"
                name="sort_order"
                min="0"
                value="{{ old('sort_order', $c?->sort_order) }}"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
        <label class="inline-flex items-center gap-2 text-sm sm:pt-6">
            <input
                type="checkbox"
                name="is_published"
                value="1"
                {{ old('is_published', $c ? $c->is_published : true) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
            >
            Published (visible on the public site)
        </label>
    </div>
</div>
