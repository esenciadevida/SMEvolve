<?php

namespace App\Services\AI;

use App\Models\AiUsage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AiUsageService
{
    public function record(array $attributes): AiUsage
    {
        $attributes['request_id'] = $attributes['request_id'] ?? Str::lower(Str::random(24));

        return AiUsage::create($attributes);
    }

    /**
     * Aggregate usage metrics, optionally scoped to a starting date.
     *
     * @return array<string, mixed>
     */
    public function metrics(?Carbon $since = null): array
    {
        $query = AiUsage::query();

        if ($since !== null) {
            $query->where('created_at', '>=', $since);
        }

        $success = (clone $query)->where('status', 'success');

        return [
            'total_requests' => (clone $query)->count(),
            'success_requests' => (clone $success)->count(),
            'failed_requests' => (clone $query)->where('status', 'error')->count(),
            'total_input_tokens' => (clone $success)->sum('input_tokens'),
            'total_output_tokens' => (clone $success)->sum('output_tokens'),
            'total_tokens' => (clone $success)->sum('total_tokens'),
            'avg_response_time_ms' => (int) round((clone $success)->avg('response_time_ms') ?? 0),
            'requests_today' => AiUsage::where('created_at', '>=', now()->startOfDay())->count(),
        ];
    }

    public function topEndpoints(int $limit = 10): array
    {
        return AiUsage::query()
            ->selectRaw('endpoint, count(*) as requests, sum(total_tokens) as tokens')
            ->whereNotNull('endpoint')
            ->groupBy('endpoint')
            ->orderByDesc('requests')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function recent(int $limit = 20): array
    {
        return AiUsage::query()
            ->with(['conversation:id,uuid', 'message:id,content'])
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
