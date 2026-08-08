<?php

namespace App\Services\Search;

use App\Services\Content\ContentService;
use Illuminate\Support\Collection;

class PackageSearchProvider extends AbstractInMemorySearchProvider
{
    private const FIELDS = ['name', 'description', '_searchFeatures'];

    public function __construct(
        private readonly ContentService $content,
    ) {
        parent::__construct('packages', 'Packages');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $packages = collect($this->content->packages())
            ->map(fn (array $item) => $item + ['_searchFeatures' => implode(' ', $item['features'] ?? [])]);

        $custom = collect(config('packages.custom_solutions.services', []))
            ->map(fn (array $service) => $service + ['features' => $service['examples'] ?? [], '_searchFeatures' => implode(' ', $service['examples'] ?? [])]);

        return $this->rank($packages->concat($custom), $query, self::FIELDS);
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || empty($record['slug'])) {
            return null;
        }

        return new SearchResult(
            type: 'package',
            id: $record['slug'],
            title: $record['name'],
            subtitle: $record['description'] ?? '',
            url: route('packages').'#website-packages',
            metadata: [
                'features' => array_slice($record['features'] ?? [], 0, 3),
            ],
        );
    }
}
