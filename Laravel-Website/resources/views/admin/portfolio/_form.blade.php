@php
    $p = $project ?? null;

    $field = fn (string $name, mixed $default = '') => old($name, $p !== null && array_key_exists($name, $p->getAttributes()) ? $p->getAttribute($name) : $default);

    $sectionValue = function (string $section, string $key, string $default = '') use ($p) {
        $existing = $p?->getAttribute($section) ?? [];

        return old("{$section}.{$key}", isset($existing[$key]) ? (string) $existing[$key] : $default);
    };

    $sectionPoints = function (string $section) use ($p) {
        $existing = $p?->getAttribute($section) ?? [];
        $points = $existing['points'] ?? [];

        return old("{$section}.points", is_array($points) ? implode("\n", $points) : '');
    };

    $listData = function (string $section) use ($p) {
        $existing = $p?->getAttribute($section) ?? [];

        return old($section, is_array($existing) ? array_values($existing) : []);
    };

    $selectedSlugs = old('services_slugs', $p?->services_slugs ?? []);

    $gallery = $listData('gallery');
    $features = $listData('features');
@endphp

<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="title" class="block text-sm font-medium">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ $field('title') }}"
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
                value="{{ $field('slug') }}"
                placeholder="e.g. warehouse-management-system"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="portfolio_category_id" class="block text-sm font-medium">Category</label>
            <select
                id="portfolio_category_id"
                name="portfolio_category_id"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
                <option value="">No category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) old('portfolio_category_id', $p?->portfolio_category_id) === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium">Status label</label>
            <input
                type="text"
                id="status"
                name="status"
                value="{{ $field('status') }}"
                placeholder="e.g. Delivered 2026"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="industry" class="block text-sm font-medium">Industry</label>
            <input
                type="text"
                id="industry"
                name="industry"
                value="{{ $field('industry') }}"
                placeholder="e.g. Retail & Distribution"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
        <div>
            <label for="project_type" class="block text-sm font-medium">Project type</label>
            <input
                type="text"
                id="project_type"
                name="project_type"
                value="{{ $field('project_type') }}"
                placeholder="e.g. Web Application"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>
    </div>

    <div>
        <label for="image" class="block text-sm font-medium">Image URL</label>
        <input
            type="url"
            id="image"
            name="image"
            value="{{ $field('image') }}"
            placeholder="https://example.com/project.jpg"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="short_description" class="block text-sm font-medium">Short description</label>
            <textarea
                id="short_description"
                name="short_description"
                rows="2"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >{{ $field('short_description') }}</textarea>
        </div>
        <div>
            <label for="summary" class="block text-sm font-medium">Summary</label>
            <textarea
                id="summary"
                name="summary"
                rows="2"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >{{ $field('summary') }}</textarea>
        </div>
    </div>

    <div>
        <label for="technologies" class="block text-sm font-medium">Technologies</label>
        <input
            type="text"
            id="technologies"
            name="technologies"
            value="{{ old('technologies', $p ? implode(', ', $p->technologies ?? []) : '') }}"
            placeholder="Laravel, MySQL, Tailwind CSS, Alpine.js"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium">Sort order</label>
        <input
            type="number"
            id="sort_order"
            name="sort_order"
            min="0"
            value="{{ $field('sort_order') }}"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
    </div>

    <div>
        <span class="block text-sm font-medium">Services</span>
        <p class="mt-0.5 text-xs text-slate-500">Select the services this project demonstrates.</p>
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach ($services as $service)
                <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                    <input
                        type="checkbox"
                        name="services_slugs[]"
                        value="{{ $service['slug'] }}"
                        {{ in_array($service['slug'], $selectedSlugs, true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                    >
                    {{ $service['name'] }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="inline-flex items-center gap-2 text-sm">
            <input
                type="checkbox"
                name="featured"
                value="1"
                {{ old('featured', $p ? $p->featured : false) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
            >
            Featured on the portfolio page
        </label>
        <label class="inline-flex items-center gap-2 text-sm">
            <input
                type="checkbox"
                name="is_published"
                value="1"
                {{ old('is_published', $p ? $p->is_published : true) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
            >
            Published (visible on the public site)
        </label>
    </div>

    <hr class="border-slate-200 dark:border-slate-800">

    <p class="text-sm font-medium">Detailed sections</p>
    <p class="-mt-2 text-xs text-slate-500">Use plain text for each section. Leave a section blank to hide it.</p>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">Challenge</p>
        <p class="mt-0.5 text-xs text-slate-500">The problem the project set out to solve.</p>
        <div class="mt-4 space-y-4">
            <div>
                <label for="challenge-heading" class="block text-xs font-medium">Heading</label>
                <input
                    type="text"
                    id="challenge-heading"
                    name="challenge[heading]"
                    value="{{ $sectionValue('challenge', 'heading') }}"
                    placeholder="e.g. Managing a fast-growing inventory"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
            <div>
                <label for="challenge-description" class="block text-xs font-medium">Description</label>
                <textarea
                    id="challenge-description"
                    name="challenge[description]"
                    rows="3"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionValue('challenge', 'description') }}</textarea>
            </div>
            <div>
                <label for="challenge-points" class="block text-xs font-medium">Points</label>
                <textarea
                    id="challenge-points"
                    name="challenge[points]"
                    rows="4"
                    placeholder="One point per line"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionPoints('challenge') }}</textarea>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">Solution</p>
        <p class="mt-0.5 text-xs text-slate-500">How the project delivered a fix.</p>
        <div class="mt-4 space-y-4">
            <div>
                <label for="solution-heading" class="block text-xs font-medium">Heading</label>
                <input
                    type="text"
                    id="solution-heading"
                    name="solution[heading]"
                    value="{{ $sectionValue('solution', 'heading') }}"
                    placeholder="e.g. A real-time stock platform"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
            <div>
                <label for="solution-description" class="block text-xs font-medium">Description</label>
                <textarea
                    id="solution-description"
                    name="solution[description]"
                    rows="3"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionValue('solution', 'description') }}</textarea>
            </div>
            <div>
                <label for="solution-points" class="block text-xs font-medium">Points</label>
                <textarea
                    id="solution-points"
                    name="solution[points]"
                    rows="4"
                    placeholder="One point per line"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionPoints('solution') }}</textarea>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">Outcome</p>
        <p class="mt-0.5 text-xs text-slate-500">Results and measurable improvements.</p>
        <div class="mt-4 space-y-4">
            <div>
                <label for="outcome-heading" class="block text-xs font-medium">Heading</label>
                <input
                    type="text"
                    id="outcome-heading"
                    name="outcome[heading]"
                    value="{{ $sectionValue('outcome', 'heading') }}"
                    placeholder="e.g. Faster picking, fewer stockouts"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
            <div>
                <label for="outcome-description" class="block text-xs font-medium">Description</label>
                <textarea
                    id="outcome-description"
                    name="outcome[description]"
                    rows="3"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionValue('outcome', 'description') }}</textarea>
            </div>
            <div>
                <label for="outcome-points" class="block text-xs font-medium">Points</label>
                <textarea
                    id="outcome-points"
                    name="outcome[points]"
                    rows="4"
                    placeholder="One point per line"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionPoints('outcome') }}</textarea>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">Key Features</p>
        <p class="mt-0.5 text-xs text-slate-500">Highlighted capabilities shown on the project page.</p>
        <div
            x-data="{
                rows: @js($features),
                addRow() { this.rows.push({ icon: 'code', title: '', description: '' }); },
                removeRow(index) { this.rows.splice(index, 1); },
            }"
            class="mt-4 space-y-4"
        >
            <template x-for="(row, index) in rows" :key="index">
                <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-800">
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <label class="block text-xs font-medium">Icon</label>
                            <input
                                type="text"
                                :name="`features[${index}][icon]`"
                                x-model="row.icon"
                                placeholder="e.g. chart-bar"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium">Title</label>
                            <input
                                type="text"
                                :name="`features[${index}][title]`"
                                x-model="row.title"
                                placeholder="e.g. Live stock levels"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium">Description</label>
                            <textarea
                                :name="`features[${index}][description]`"
                                x-model="row.description"
                                rows="1"
                                placeholder="What this feature does"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            ></textarea>
                        </div>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button
                            type="button"
                            x-on:click="removeRow(index)"
                            class="inline-flex items-center gap-1 rounded-lg border border-error-500/30 px-3 py-1.5 text-xs font-medium text-error-600 hover:bg-error-500/10 dark:text-error-400"
                        >
                            <x-icon name="trash" class="h-3.5 w-3.5" /> Remove
                        </button>
                    </div>
                </div>
            </template>
            <button
                type="button"
                x-on:click="addRow()"
                class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
            >
                <span class="text-sm leading-none">+</span> Add feature
            </button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">Gallery</p>
        <p class="mt-0.5 text-xs text-slate-500">Screenshots shown on the project page.</p>
        <div
            x-data="{
                rows: @js($gallery),
                addRow() { this.rows.push({ label: '', type: '', image: '' }); },
                removeRow(index) { this.rows.splice(index, 1); },
            }"
            class="mt-4 space-y-4"
        >
            <template x-for="(row, index) in rows" :key="index">
                <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-800">
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <label class="block text-xs font-medium">Label</label>
                            <input
                                type="text"
                                :name="`gallery[${index}][label]`"
                                x-model="row.label"
                                placeholder="e.g. Dashboard"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium">Caption</label>
                            <input
                                type="text"
                                :name="`gallery[${index}][type]`"
                                x-model="row.type"
                                placeholder="e.g. Overview of stock levels"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium">Image URL</label>
                            <input
                                type="url"
                                :name="`gallery[${index}][image]`"
                                x-model="row.image"
                                placeholder="https://example.com/screenshot.jpg"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                            >
                        </div>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button
                            type="button"
                            x-on:click="removeRow(index)"
                            class="inline-flex items-center gap-1 rounded-lg border border-error-500/30 px-3 py-1.5 text-xs font-medium text-error-600 hover:bg-error-500/10 dark:text-error-400"
                        >
                            <x-icon name="trash" class="h-3.5 w-3.5" /> Remove
                        </button>
                    </div>
                </div>
            </template>
            <button
                type="button"
                x-on:click="addRow()"
                class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
            >
                <span class="text-sm leading-none">+</span> Add image
            </button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-medium">SEO meta</p>
        <p class="mt-0.5 text-xs text-slate-500">Optional search-engine fields for this project page.</p>
        <div class="mt-4 space-y-4">
            <div>
                <label for="meta-title" class="block text-xs font-medium">SEO title</label>
                <input
                    type="text"
                    id="meta-title"
                    name="meta[title]"
                    value="{{ $sectionValue('meta', 'title') }}"
                    placeholder="e.g. Warehouse Management System case study"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
            <div>
                <label for="meta-description" class="block text-xs font-medium">SEO description</label>
                <textarea
                    id="meta-description"
                    name="meta[description]"
                    rows="2"
                    placeholder="How we solved stock tracking for a growing retailer."
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ $sectionValue('meta', 'description') }}</textarea>
            </div>
        </div>
    </div>
</div>
