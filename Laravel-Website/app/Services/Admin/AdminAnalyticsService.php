<?php

namespace App\Services\Admin;

use App\Models\AdminAuditLog;
use App\Models\AiHandoff;
use App\Models\AiUsage;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AdminAnalyticsService
{
    /**
     * @return array<string, int>
     */
    public function quoteMetrics(): array
    {
        $base = QuoteSubmission::query();

        return [
            'total' => (clone $base)->count(),
            'new' => (clone $base)->where('status', QuoteSubmission::STATUS_SUBMITTED)->count(),
            'in_progress' => (clone $base)
                ->whereIn('status', [QuoteSubmission::STATUS_UNDER_REVIEW, QuoteSubmission::STATUS_QUOTED])
                ->count(),
            'completed' => (clone $base)->where('status', QuoteSubmission::STATUS_COMPLETED)->count(),
        ];
    }

    /**
     * Quote submissions per day over the trailing window (oldest first).
     *
     * @return array<int, array{label: string, full: string, value: int}>
     */
    public function quotesDaily(int $days = 14): array
    {
        $from = now()->startOfDay()->subDays($days - 1);

        $counts = QuoteSubmission::query()
            ->whereNotNull('submitted_at')
            ->whereDate('submitted_at', '>=', $from)
            ->selectRaw('DATE(submitted_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        return $this->dailySeries($from, $counts);
    }

    /**
     * @return array<int, array{label: string, value: int, color: string}>
     */
    public function quoteStatusCounts(): array
    {
        $labels = [
            QuoteSubmission::STATUS_SUBMITTED => ['Submitted', 'primary'],
            QuoteSubmission::STATUS_UNDER_REVIEW => ['Under Review', 'warning'],
            QuoteSubmission::STATUS_QUOTED => ['Quoted', 'info'],
            QuoteSubmission::STATUS_COMPLETED => ['Completed', 'success'],
            QuoteSubmission::STATUS_CANCELLED => ['Cancelled', 'error'],
        ];

        return collect($labels)
            ->map(fn ($meta, $status) => [
                'label' => $meta[0],
                'value' => QuoteSubmission::where('status', $status)->count(),
                'color' => $meta[1],
            ])
            ->filter(fn ($item) => $item['value'] > 0)
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{label: string, value: int}>
     */
    public function quoteFunnel(): array
    {
        return [
            ['label' => 'Sessions started', 'value' => QuoteSession::query()->count()],
            ['label' => 'Quotes submitted', 'value' => QuoteSubmission::query()->count()],
            ['label' => 'Quotes completed', 'value' => QuoteSubmission::where('status', QuoteSubmission::STATUS_COMPLETED)->count()],
        ];
    }

    /**
     * @return array<string, int|float>
     */
    public function aiMetrics(): array
    {
        $query = AiUsage::query();

        $success = (clone $query)->where('status', 'success');
        $today = (clone $query)->where('created_at', '>=', now()->startOfDay());
        $successToday = (clone $success)->where('created_at', '>=', now()->startOfDay());

        $total = (clone $query)->count();
        $successful = (clone $success)->count();

        return [
            'total_requests' => $total,
            'success_requests' => $successful,
            'failed_requests' => (clone $query)->where('status', 'error')->count(),
            'success_rate' => $total > 0 ? round(($successful / $total) * 100, 1) : 0,
            'total_tokens' => (clone $success)->sum('total_tokens'),
            'avg_response_time_ms' => (int) round((clone $success)->avg('response_time_ms') ?? 0),
            'requests_today' => (clone $today)->count(),
            'tokens_today' => (clone $successToday)->sum('total_tokens'),
        ];
    }

    /**
     * AI requests per day over the trailing window (oldest first).
     *
     * @return array<int, array{label: string, full: string, requests: int, tokens: int}>
     */
    public function aiDaily(int $days = 14): array
    {
        $from = now()->startOfDay()->subDays($days - 1);

        $rows = AiUsage::query()
            ->where('created_at', '>=', $from)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as requests, COALESCE(SUM(total_tokens), 0) as tokens')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $series = [];

        for ($i = 0; $i < $days; $i++) {
            $date = (clone $from)->addDays($i);
            $key = $date->format('Y-m-d');
            $row = $rows->get($key);

            $series[] = [
                'label' => $date->format('M j'),
                'full' => $key,
                'requests' => (int) ($row->requests ?? 0),
                'tokens' => (int) ($row->tokens ?? 0),
            ];
        }

        return $series;
    }

    /**
     * @return array<int, array{label: string, value: int, tokens: int}>
     */
    public function aiEndpointStats(int $limit = 5): array
    {
        return AiUsage::query()
            ->whereNotNull('endpoint')
            ->selectRaw('endpoint, COUNT(*) as requests, COALESCE(SUM(total_tokens), 0) as tokens')
            ->groupBy('endpoint')
            ->orderByDesc('requests')
            ->limit($limit)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->endpoint,
                'value' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
            ])
            ->all();
    }

    /**
     * @return array<int, array{label: string, value: int, tokens: int}>
     */
    public function aiModelStats(int $limit = 5): array
    {
        return AiUsage::query()
            ->whereNotNull('model')
            ->selectRaw('model, COUNT(*) as requests, COALESCE(SUM(total_tokens), 0) as tokens')
            ->groupBy('model')
            ->orderByDesc('requests')
            ->limit($limit)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->model,
                'value' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
            ])
            ->all();
    }

    /**
     * @return array<string, int>
     */
    public function chatbotStats(): array
    {
        return [
            'conversations' => Conversation::query()->count(),
            'messages' => Message::query()->count(),
            'user_messages' => Message::where('role', Message::ROLE_USER)->count(),
            'assistant_messages' => Message::where('role', Message::ROLE_ASSISTANT)->count(),
            'handoffs' => AiHandoff::query()->count(),
        ];
    }

    /**
     * Admin audit activity per day over the trailing window (oldest first).
     *
     * @return array<int, array{label: string, full: string, value: int}>
     */
    public function adminActivityDaily(int $days = 14): array
    {
        $from = now()->startOfDay()->subDays($days - 1);

        $counts = AdminAuditLog::query()
            ->whereDate('created_at', '>=', $from)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        return $this->dailySeries($from, $counts);
    }

    /**
     * Build a zero-padded daily series from a day-keyed lookup map.
     *
     * @param  Collection<string, mixed>  $counts
     * @return array<int, array{label: string, full: string, value: int}>
     */
    private function dailySeries(Carbon $from, Collection $counts): array
    {
        $days = $from->diffInDays(now()->startOfDay()) + 1;
        $series = [];

        for ($i = 0; $i < $days; $i++) {
            $date = (clone $from)->addDays($i);
            $key = $date->format('Y-m-d');

            $series[] = [
                'label' => $date->format('M j'),
                'full' => $key,
                'value' => (int) ($counts[$key] ?? 0),
            ];
        }

        return $series;
    }
}
