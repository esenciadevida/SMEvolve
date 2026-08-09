<?php

namespace App\Services\AI;

use App\Models\AiAuditLog;
use App\Services\Security\RequestMetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiAuditService
{
    public function __construct(private readonly RequestMetaService $meta) {}

    public function log(
        string $action,
        ?string $resourceType = null,
        ?string $resourceId = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?Request $request = null
    ): AiAuditLog {
        return AiAuditLog::create([
            'admin_id' => $this->adminId(),
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'old_value' => $this->encode($oldValue),
            'new_value' => $this->encode($newValue),
            'ip_address' => $request?->ip(),
            'user_agent' => $request !== null ? mb_substr((string) $request->userAgent(), 0, 255) : null,
            'browser' => $request !== null ? $this->meta->browser($request->userAgent()) : null,
            'os' => $request !== null ? $this->meta->operatingSystem($request->userAgent()) : null,
            'device_type' => $request !== null ? $this->meta->deviceType($request->userAgent()) : null,
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

    private function adminId(): ?string
    {
        $administrator = Auth::guard('admin')->user();

        return $administrator !== null ? (string) $administrator->id : null;
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
