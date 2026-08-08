@php
    $platforms = collect($values['social_links.platforms'] ?? config('social_links.platforms', []));
@endphp

<x-layouts.admin-portal :title="'Social Settings'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Website Settings</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage the social media links displayed in the website footer.</p>
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

    <form method="POST" action="{{ route('admin.settings.update', ['group' => 'social']) }}" x-data="{ submitting: false }" x-on:submit="submitting = true" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        @foreach ($platforms as $index => $platform)
            <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-800">
                <div class="flex items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm font-medium">
                        <input
                            type="checkbox"
                            name="platforms[{{ $platform['platform'] }}][enabled]"
                            value="1"
                            {{ ($platform['enabled'] ?? false) ? 'checked' : '' }}
                            class="rounded border-slate-300 dark:border-slate-700"
                        >
                        {{ $platform['label'] ?? $platform['platform'] }}
                    </label>
                    <span class="text-xs text-slate-400">{{ $platform['platform'] }}</span>
                </div>

                <input
                    type="hidden"
                    name="platforms[{{ $platform['platform'] }}][platform]"
                    value="{{ $platform['platform'] }}"
                >

                <label for="platform-{{ $platform['platform'] }}" class="mt-3 block text-xs font-medium text-slate-500">Profile URL</label>
                <input
                    type="url"
                    id="platform-{{ $platform['platform'] }}"
                    name="platforms[{{ $platform['platform'] }}][href]"
                    value="{{ old('platforms.'.$platform['platform'].'.href', $platform['href'] ?? '') }}"
                    placeholder="https://"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>
        @endforeach

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" :disabled="submitting" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60">
                Save changes
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
