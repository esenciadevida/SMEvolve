<?php

namespace App\Services\Admin;

use App\Models\AdminAuditLog;
use App\Models\Administrator;
use App\Services\Security\RequestMetaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdminAuditService
{
    public function __construct(private readonly RequestMetaService $meta) {}

    /**
     * Record an administrative action with security metadata (browser, OS,
     * device type and approximate location) captured from the request.
     */
    public function log(
        string $action,
        ?string $resourceType = null,
        ?string $resourceId = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?Request $request = null,
        ?Administrator $actor = null,
        string $status = 'success',
        ?string $description = null,
        ?string $requestId = null,
    ): AdminAuditLog {
        return AdminAuditLog::create([
            'administrator_id' => $actor?->id,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'old_value' => $this->encode($oldValue),
            'new_value' => $this->encode($newValue),
            'status' => $status,
            'description' => $description !== null ? mb_substr($description, 0, 500) : null,
            'request_id' => $requestId ?? Str::uuid()->toString(),
            'ip_address' => $request?->ip(),
            'user_agent' => $request !== null ? mb_substr((string) $request->userAgent(), 0, 255) : null,
            'browser' => $request !== null ? $this->meta->browser($request->userAgent()) : null,
            'os' => $request !== null ? $this->meta->operatingSystem($request->userAgent()) : null,
            'device_type' => $request !== null ? $this->meta->deviceType($request->userAgent()) : null,
            'location' => $request !== null ? $this->meta->capture($request)['location'] : null,
        ]);
    }

    /**
     * Record a failed administrator login attempt. The account may not exist,
     * so no actor is linked; the attempted email is kept in the description
     * only (never the password).
     */
    public function logFailedLogin(Request $request, string $email, string $reason): AdminAuditLog
    {
        return $this->log(
            'admin.login.failed',
            'administrators',
            null,
            request: $request,
            status: 'failure',
            description: 'Failed login for '.mb_substr($email, 0, 190).' ('.$reason.')',
        );
    }

    public function recent(int $limit = 10): Collection
    {
        return AdminAuditLog::query()
            ->with('administrator:id,name,email')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Recent sign-in related events for a single administrator (used by the
     * account security screen).
     */
    public function recentForAdministrator(Administrator $administrator, int $limit = 10): Collection
    {
        return AdminAuditLog::query()
            ->where('administrator_id', $administrator->id)
            ->whereIn('action', ['admin.login', 'admin.login.failed', 'admin.logout', 'security.password_change'])
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Count failed login attempts within the trailing window for the current
     * request IP.
     */
    public function failedLoginCountForIp(string $ip, int $minutes = 60): int
    {
        return AdminAuditLog::query()
            ->where('action', 'admin.login.failed')
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    public function search(array $filters = []): LengthAwarePaginator
    {
        $query = AdminAuditLog::query()
            ->with('administrator:id,name,email')
            ->when($filters['query'] ?? null, fn ($q, $term) => $q->where(function ($w) use ($term) {
                $w->where('action', 'like', "%{$term}%")
                    ->orWhere('resource_type', 'like', "%{$term}%")
                    ->orWhere('resource_id', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            }))
            ->when($filters['action'] ?? null, fn ($q, $action) => $q->where('action', $action))
            ->when($filters['administrator_id'] ?? null, fn ($q, $id) => $q->where('administrator_id', $id))
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($filters['target'] ?? null, fn ($q, $target) => $q->where('resource_type', $target))
            ->when($filters['ip'] ?? null, fn ($q, $ip) => $q->where('ip_address', $ip))
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

    /**
     * Distinct resource types referenced in the audit log (for the target
     * filter).
     *
     * @return array<int, string>
     */
    public function distinctResourceTypes(): array
    {
        return AdminAuditLog::query()
            ->whereNotNull('resource_type')
            ->distinct()
            ->orderBy('resource_type')
            ->pluck('resource_type')
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
