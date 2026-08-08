<?php

namespace App\Services\Admin;

use App\Models\Administrator;
use App\Models\QuoteSubmission;
use App\Services\AI\AiConfigService;
use App\Services\AI\AIProviderInterface;

class AdminDashboardService
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AiConfigService $aiConfigService,
        private readonly AIProviderInterface $provider,
    ) {
    }

    /**
     * Build the permission-aware dashboard data for an administrator.
     *
     * @return array<string, mixed>
     */
    public function build(Administrator $administrator): array
    {
        $data = [
            'quoteMetrics' => null,
            'recentQuotes' => null,
            'recentActivity' => null,
            'chatbotStatus' => null,
            'aiStatus' => null,
            'warnings' => [],
        ];

        if ($administrator->hasPermission('quotes.view')) {
            $data['quoteMetrics'] = $this->quoteMetrics();
            $data['recentQuotes'] = $this->recentQuotes();
        }

        if ($administrator->hasPermission('audit.view')) {
            $data['recentActivity'] = $this->auditService->recent(6);
        }

        if ($administrator->hasPermission('chatbot.view')) {
            $data['chatbotStatus'] = $this->chatbotStatus();
        }

        if ($administrator->hasPermission('ai.view')) {
            $data['aiStatus'] = $this->aiStatus();
            $data['warnings'] = array_merge($data['warnings'], $this->aiWarnings());
        }

        return $data;
    }

    /**
     * @return array<string, int>
     */
    private function quoteMetrics(): array
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

    private function recentQuotes(): \Illuminate\Database\Eloquent\Collection
    {
        return QuoteSubmission::query()
            ->orderByDesc('id')
            ->limit(5)
            ->get(['id', 'reference', 'status', 'contact_name', 'submitted_at']);
    }

    /**
     * @return array{label: string, state: string}
     */
    private function chatbotStatus(): array
    {
        if (! (bool) config('ai.enabled')) {
            return ['label' => 'Disabled', 'state' => 'disabled'];
        }

        return $this->aiConfigService->assistantEnabled()
            ? ['label' => 'Active', 'state' => 'active']
            : ['label' => 'Disabled', 'state' => 'disabled'];
    }

    /**
     * @return array{label: string, state: string}
     */
    private function aiStatus(): array
    {
        if (! (bool) config('ai.enabled')) {
            return ['label' => 'Disabled', 'state' => 'disabled'];
        }

        if (! $this->provider->isConfigured()) {
            return ['label' => 'Configuration Required', 'state' => 'warning'];
        }

        return ['label' => 'Operational', 'state' => 'active'];
    }

    /**
     * @return array<int, string>
     */
    private function aiWarnings(): array
    {
        $warnings = [];

        if ((bool) config('ai.enabled') && ! $this->provider->isConfigured()) {
            $warnings[] = 'The AI service is enabled but no provider key is configured.';
        }

        return $warnings;
    }
}
