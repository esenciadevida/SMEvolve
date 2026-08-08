<?php

namespace App\Services\Search;

use App\Models\Administrator;

interface SearchContract
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
     * Permission required to search this resource, or null when no
     * permission check applies.
     */
    public function permission(): ?string;

    /**
     * Whether the given administrator is authorized to search this resource.
     */
    public function canSearch(Administrator $administrator): bool;

    /**
     * Run a search and return normalized results for this resource.
     *
     * @return array<int, array{type: string, id: int|string, title: string, subtitle: string, url: string, metadata: array<string, mixed>}>
     */
    public function search(string $query, int $limit = 5): array;
}
