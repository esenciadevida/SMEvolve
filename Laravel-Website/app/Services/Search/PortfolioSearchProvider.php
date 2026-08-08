<?php

namespace App\Services\Search;

use App\Data\Portfolio\PortfolioData;
use Illuminate\Support\Collection;

class PortfolioSearchProvider extends AbstractInMemorySearchProvider
{
    private const FIELDS = ['title', 'description', 'category', 'technologies'];

    public function __construct(
        private readonly PortfolioData $portfolio,
    ) {
        parent::__construct('portfolio', 'Portfolio');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $catalog = $this->portfolio->catalog()->map(function (array $project) {
            $project['technologies'] = implode(' ', $project['technologies'] ?? []);

            return $project;
        });

        return $this->rank($catalog, $query, self::FIELDS, 'title');
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || empty($record['slug'])) {
            return null;
        }

        return new SearchResult(
            type: 'portfolio',
            id: $record['slug'],
            title: $record['title'],
            subtitle: $record['description'] ?? '',
            url: $record['url'] ?? route('portfolio.show', $record['slug']),
            metadata: [
                'category' => $record['category'] ?? null,
            ],
        );
    }
}
