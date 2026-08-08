<?php

namespace App\Services\Search;

use App\Services\Content\ContentService;
use Illuminate\Support\Collection;

class ServiceSearchProvider extends AbstractInMemorySearchProvider
{
    private const FIELDS = ['name', 'description', 'slug'];

    public function __construct(
        private readonly ContentService $content,
    ) {
        parent::__construct('services', 'Services');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        return $this->rank(collect($this->content->services()), $query, self::FIELDS);
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || empty($record['slug'])) {
            return null;
        }

        return new SearchResult(
            type: 'service',
            id: $record['slug'],
            title: $record['name'],
            subtitle: $record['description'] ?? '',
            url: route('services.show', $record['slug']),
            metadata: [
                'icon' => $record['icon'] ?? 'code',
            ],
        );
    }
}
