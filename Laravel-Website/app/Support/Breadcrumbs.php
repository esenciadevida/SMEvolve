<?php

namespace App\Support;

class Breadcrumbs
{
    /**
     * Build a breadcrumb trail.
     *
     * Sections come from config('breadcrumbs.sections'); the current page
     * label is appended as the final, non-linked item.
     *
     * @return array<int, array{label: string, url?: string}>
     */
    public static function page(?string $section, ?string $current = null): array
    {
        $trail = [];

        if ($section !== null && isset(config('breadcrumbs.sections')[$section])) {
            $config = config('breadcrumbs.sections')[$section];
            $trail[] = [
                'label' => $config['label'],
                'url' => route($config['route'], $config['params'] ?? []),
            ];
        }

        if (filled($current)) {
            $trail[] = ['label' => $current];
        }

        return $trail;
    }

    /**
     * Structured data for the given trail.
     *
     * @param  array<int, array{label: string, url?: string}>  $trail
     * @return array<string, mixed>
     */
    public static function schema(array $trail): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($trail)->values()->map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => $item['url'] ?? url()->current(),
            ])->all(),
        ];
    }
}
