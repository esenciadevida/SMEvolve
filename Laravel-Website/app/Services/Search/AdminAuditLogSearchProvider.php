<?php

namespace App\Services\Search;

use App\Models\AdminAuditLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AdminAuditLogSearchProvider extends AbstractSearchProvider
{
    private const COLUMNS = ['action', 'resource_type', 'resource_id', 'new_value'];

    public function __construct()
    {
        parent::__construct('audit_logs', 'Audit Log', 'audit.view');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return AdminAuditLog::query()
            ->with('administrator')
            ->where(function (Builder $builder) use ($lower) {
                $this->whereAnyMatch($builder, self::COLUMNS, $lower);

                $builder->orWhereHas('administrator', function (Builder $relation) use ($lower) {
                    $relation->whereRaw('LOWER(name) = ?', [$lower])
                        ->orWhereRaw('LOWER(name) LIKE ?', [$lower.'%'])
                        ->orWhereRaw('LOWER(name) LIKE ?', ['%'.$lower.'%']);
                });
            })
            ->orderByRaw(
                'CASE
                    WHEN LOWER(action) = ? THEN 0
                    WHEN LOWER(action) LIKE ? THEN 1
                    WHEN LOWER(resource_type) LIKE ? THEN 2
                    ELSE 3
                END',
                [$lower, $lower.'%', $lower.'%']
            )
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! $record instanceof AdminAuditLog) {
            return null;
        }

        $resourceType = Str::headline(Str::replace('.', ' ', $record->resource_type));

        return new SearchResult(
            type: 'audit_log',
            id: $record->id,
            title: Str::headline(Str::replace('.', ' ', $record->action)),
            subtitle: sprintf(
                '%s #%s · by %s',
                $resourceType,
                $record->resource_id,
                $record->administrator?->name ?? 'System'
            ),
            url: route('admin.audit.index', ['q' => $record->resource_id]),
            metadata: [
                'group' => $resourceType,
                'action' => $record->action,
            ],
        );
    }
}
