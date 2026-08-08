@php
    $route = $document['route'] ?? 'home';
    $title = $document['meta']['title'] ?? $document['title'] ?? 'SMEvolve';
    $description = $document['meta']['description'] ?? null;
    $trail = [['label' => 'Home', 'url' => route('home')], ['label' => $document['title'] ?? '']];
@endphp

<x-layouts.app
    :title="$title"
    :description="$description"
    :canonical="route($route)"
>
    <x-slot name="structuredData">
        <x-legal.metadata :document="$document" :trail="$trail" />
    </x-slot>

    <x-legal.hero :document="$document" />

    <section id="legal-document" aria-labelledby="legal-document-heading" class="bg-white dark:bg-dark">
        <div class="mx-auto w-full max-w-site px-6 py-16 lg:px-8 lg:py-24">
            <div class="mx-auto w-full max-w-3xl">
                <dl class="flex flex-wrap gap-x-8 gap-y-3 border-b border-gray-200 pb-6 text-sm text-gray-500 dark:border-white/10 dark:text-slate-400">
                    @if (filled($document['updated_date'] ?? null))
                        <div class="flex items-center gap-2">
                            <dt>Last Updated:</dt>
                            <dd class="font-medium text-gray-700 dark:text-slate-200">{{ $document['updated_date'] }}</dd>
                        </div>
                    @endif

                    @if (filled($document['effective_date'] ?? null))
                        <div class="flex items-center gap-2">
                            <dt>Effective:</dt>
                            <dd class="font-medium text-gray-700 dark:text-slate-200">{{ $document['effective_date'] }}</dd>
                        </div>
                    @endif

                    @if (filled($document['version'] ?? null))
                        <div class="flex items-center gap-2">
                            <dt>Version:</dt>
                            <dd class="font-medium text-gray-700 dark:text-slate-200">{{ $document['version'] }}</dd>
                        </div>
                    @endif
                </dl>

                <x-legal.content :document="$document" />
            </div>
        </div>
    </section>

    <x-sections.contact-information />

    <x-sections.final-cta
        :label="$document['cta']['label'] ?? null"
        :heading="$document['cta']['heading'] ?? null"
        :description="$document['cta']['description'] ?? null"
        :primary-text="$document['cta']['primary']['label'] ?? null"
        :primary-href="isset($document['cta']['primary']['route']) ? route($document['cta']['primary']['route']) : null"
        :secondary-text="$document['cta']['secondary']['label'] ?? null"
        :secondary-href="isset($document['cta']['secondary']['route']) ? route($document['cta']['secondary']['route']) : null"
        :trust="$document['cta']['trust'] ?? []"
        :trust-note="$document['cta']['trust_note'] ?? null"
    />
</x-layouts.app>
