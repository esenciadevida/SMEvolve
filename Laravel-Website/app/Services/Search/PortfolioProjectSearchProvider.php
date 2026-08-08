<?php

namespace App\Services\Search;

use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PortfolioProjectSearchProvider extends AbstractSearchProvider
{
    private const COLUMNS = ['title', 'slug', 'industry'];

    public function __construct()
    {
        parent::__construct('portfolio', 'Portfolio Projects', 'portfolio.view');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return PortfolioProject::query()
            ->with('category')
            ->tap(fn (Builder $builder) => $this->whereAnyMatch($builder, self::COLUMNS, $lower))
            ->orderByRaw(
                'CASE
                    WHEN LOWER(title) = ? THEN 0
                    WHEN LOWER(slug) = ? THEN 1
                    ELSE 2
                END',
                [$lower, $lower]
            )
            ->orderBy('title')
            ->limit($limit)
            ->get();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! $record instanceof PortfolioProject) {
            return null;
        }

        return new SearchResult(
            type: 'project',
            id: $record->id,
            title: $record->title,
            subtitle: $record->category?->name ? "{$record->category->name} · /{$record->slug}" : "/{$record->slug}",
            url: route('admin.portfolio.edit', $record),
            metadata: [
                'is_published' => $record->is_published,
                'featured' => $record->featured,
            ],
        );
    }
}
