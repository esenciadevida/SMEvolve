<?php

namespace App\Services\Search;

use Illuminate\Support\Collection;

abstract class AbstractInMemorySearchProvider implements PublicSearchContract
{
    public function __construct(
        private readonly string $key,
        private readonly string $label,
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function search(string $query, int $limit = 5): array
    {
        $normalized = mb_strtolower(trim($query));

        if ($normalized === '') {
            return [];
        }

        return $this->searchRecords($normalized, $limit)
            ->map(fn (mixed $record) => $this->normalizeResult($record))
            ->filter()
            ->take($limit)
            ->values()
            ->map(fn (SearchResult $result) => $result->toArray())
            ->all();
    }

    /**
     * Rank in-memory records against a query over the given fields.
     *
     * Exact matches rank highest, then prefix matches, then substring
     * matches. Records that match no field are dropped, and the original
     * record order is preserved within the same relevance score.
     *
     * @param  Collection<int, array<string, mixed>>  $records
     * @param  array<int, string>  $fields
     * @return Collection<int, array<string, mixed>>
     */
    protected function rank(Collection $records, string $query, array $fields, string $titleField = 'name'): Collection
    {
        return $records
            ->map(function (array $record) use ($query, $fields, $titleField) {
                $score = null;

                foreach ($fields as $field) {
                    $value = data_get($record, $field);

                    if (! is_string($value) || $value === '') {
                        continue;
                    }

                    $value = mb_strtolower($value);

                    $candidate = match (true) {
                        $value === $query => 0,
                        str_starts_with($value, $query) => 1,
                        str_contains($value, $query) => 2,
                        default => null,
                    };

                    if ($candidate === null) {
                        continue;
                    }

                    $score = $score === null ? $candidate : min($score, $candidate);

                    if ($score === 0) {
                        break;
                    }
                }

                if ($score === null) {
                    return null;
                }

                $record['_searchScore'] = $score;
                $record['_searchTitle'] = mb_strtolower((string) data_get($record, $titleField, ''));

                return $record;
            })
            ->filter()
            ->sortBy(['_searchScore', '_searchTitle'])
            ->values();
    }

    /**
     * @return Collection<int, mixed>
     */
    abstract protected function searchRecords(string $query, int $limit): Collection;

    abstract protected function normalizeResult(mixed $record): ?SearchResult;
}
