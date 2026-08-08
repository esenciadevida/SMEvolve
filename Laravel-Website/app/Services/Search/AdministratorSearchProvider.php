<?php

namespace App\Services\Search;

use App\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AdministratorSearchProvider extends AbstractSearchProvider
{
    private const COLUMNS = ['name', 'email'];

    public function __construct()
    {
        parent::__construct('administrators', 'Administrators', 'administrators.view');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return Administrator::query()
            ->with('role')
            ->tap(fn (Builder $builder) => $this->whereAnyMatch($builder, self::COLUMNS, $lower))
            ->orderByRaw(
                'CASE
                    WHEN LOWER(name) = ? THEN 0
                    WHEN LOWER(email) = ? THEN 1
                    WHEN LOWER(name) LIKE ? OR LOWER(email) LIKE ? THEN 2
                    ELSE 3
                END',
                [$lower, $lower, $lower . '%', $lower . '%']
            )
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! $record instanceof Administrator) {
            return null;
        }

        return new SearchResult(
            type: 'administrator',
            id: $record->id,
            title: $record->name,
            subtitle: $record->email,
            url: route('admin.administrators.show', $record),
            metadata: [
                'is_active' => $record->is_active,
                'role' => $record->role?->label,
            ],
        );
    }
}
