<?php

namespace App\Services\Search;

interface PublicSearchContract
{
    /**
     * Unique provider key used as the result group identifier.
     */
    public function key(): string;

    /**
     * Human-readable resource label shown in the search interface.
     */
    public function label(): string;

    /**
     * Run a search and return normalized results for this resource.
     *
     * @return array<int, array{type: string, id: int|string, title: string, subtitle: string, url: string, metadata: array<string, mixed>}>
     */
    public function search(string $query, int $limit = 5): array;
}
