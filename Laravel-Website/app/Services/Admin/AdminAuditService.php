<?php

namespace App\Services\Admin;

use App\Models\AdminAuditLog;
use App\Models\Administrator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminAuditService
{
    public function log(
        string $action,
        ?string $resourceType = null,
        ?string $resourceId = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?Request $request = null,
        ?Administrator $actor = null,
    ): AdminAuditLog {
        return AdminAuditLog::create([
            'administrator_id' => $actor?->id,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'old_value' => $this->encode($oldValue),
            'new_value' => $this->encode($newValue),
            'ip_address' => $request?->ip(),
            'user_agent' => $request !== null ? mb_substr((string) $request->userAgent(), 0, 255) : null,
        ]);
    }

    public function recent(int $limit = 10): Collection
    {
        return AdminAuditLog::query()
            ->with('administrator:id,name,email')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function search(array $filters = []): LengthAwarePaginator
    {
        $query = AdminAuditLog::query()
            ->with('administrator:id,name,email')
            ->when($filters['query'] ?? null, fn ($q, $term) => $q->where(function ($w) use ($term) {
                $w->where('action', 'like', "%{$term}%")
                    ->orWhere('resource_type', 'like', "%{$term}%")
                    ->orWhere('resource_id', 'like', "%{$term}%");
            }))
            ->when($filters['action'] ?? null, fn ($q, $action) => $q->where('action', $action))
            ->when($filters['administrator_id'] ?? null, fn ($q, $id) => $q->where('administrator_id', $id))
            ->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->orderByDesc('id');

        return $query->paginate($filters['per_page'] ?? 25)->withQueryString();
    }

    public function distinctActions(): array
    {
        return AdminAuditLog::query()
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->all();
    }

    private function encode(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            $encoded = json_encode($value);
            $value = $encoded === false ? null : $encoded;
        }

        return (string) $value;
    }
}
