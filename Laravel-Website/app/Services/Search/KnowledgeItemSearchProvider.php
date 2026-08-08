<?php

namespace App\Services\Search;

use App\Models\KnowledgeItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KnowledgeItemSearchProvider extends AbstractSearchProvider
{
    private const COLUMNS = ['title', 'content'];

    public function __construct()
    {
        parent::__construct('knowledge', 'Knowledge', 'ai.view');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return KnowledgeItem::query()
            ->tap(fn (Builder $builder) => $this->whereAnyMatch($builder, self::COLUMNS, $lower))
            ->orderByRaw(
                'CASE
                    WHEN LOWER(title) = ? THEN 0
                    WHEN LOWER(title) LIKE ? THEN 1
                    WHEN LOWER(title) LIKE ? THEN 2
                    ELSE 3
                END',
                [$lower, $lower.'%', '%'.$lower.'%']
            )
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! $record instanceof KnowledgeItem) {
            return null;
        }

        return new SearchResult(
            type: 'knowledge',
            id: $record->id,
            title: $record->title,
            subtitle: Str::limit(Str::of($record->content)->stripTags()->toString(), 120),
            url: route('admin.ai.knowledge.index', ['search' => $record->title]),
            metadata: [
                'status' => ucfirst($record->status),
                'status_key' => $record->status,
            ],
        );
    }
}
