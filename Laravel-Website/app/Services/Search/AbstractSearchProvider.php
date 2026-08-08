<?php

namespace App\Services\Search;

use App\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class AbstractSearchProvider implements SearchContract
{
    public function __construct(
        private readonly string $key,
        private readonly string $label,
        private readonly ?string $permission = null,
    ) {}

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function permission(): ?string
    {
        return $this->permission;
    }

    public function canSearch(Administrator $administrator): bool
    {
        return $this->permission === null || $administrator->hasPermission($this->permission);
    }

    public function search(string $query, int $limit = 5): array
    {
        return $this->searchRecords($query, $limit)
            ->map(fn (mixed $record) => $this->normalizeResult($record))
            ->filter()
            ->values()
            ->map(fn (SearchResult $result) => $result->toArray())
            ->all();
    }

    /**
     * Apply the column list as a case-insensitive exact / prefix / contains
     * match group. Column names are provider constants, never user input.
     *
     * @param  array<int, string>  $columns
     */
    protected function whereAnyMatch(Builder $builder, array $columns, string $lower): void
    {
        $builder->where(function (Builder $query) use ($columns, $lower) {
            foreach ($columns as $column) {
                $query->orWhereRaw('LOWER('.$column.') = ?', [$lower])
                    ->orWhereRaw('LOWER('.$column.') LIKE ?', [$lower.'%'])
                    ->orWhereRaw('LOWER('.$column.') LIKE ?', ['%'.$lower.'%']);
            }
        });
    }

    /**
     * @return Collection<int, mixed>
     */
    abstract protected function searchRecords(string $query, int $limit): Collection;

    abstract protected function normalizeResult(mixed $record): ?SearchResult;
}
