<?php

namespace App\Services\AI;

use App\Models\AiAuditLog;
use Illuminate\Http\Request;

class AiAuditService
{
    public function log(
        string $action,
        ?string $resourceType = null,
        ?string $resourceId = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?Request $request = null
    ): AiAuditLog {
        return AiAuditLog::create([
            'admin_id' => $this->adminId($request),
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'old_value' => $this->encode($oldValue),
            'new_value' => $this->encode($newValue),
            'ip_address' => $request?->ip(),
            'user_agent' => $request !== null ? mb_substr((string) $request->userAgent(), 0, 255) : null,
        ]);
    }

    public function recent(int $limit = 30): array
    {
        return AiAuditLog::query()
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    private function adminId(?Request $request): ?string
    {
        if ($request === null) {
            return 'system';
        }

        return (string) ($request->session()->get(config('ai.admin.session_key'), 'unknown'));
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
