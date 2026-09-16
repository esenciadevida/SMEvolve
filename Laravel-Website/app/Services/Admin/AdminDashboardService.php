<?php

namespace App\Services\Admin;

use App\Models\AdminAuditLog;
use App\Models\Administrator;
use App\Models\PageView;
use App\Models\QuoteSubmission;
use App\Services\AI\AiConfigService;
use App\Services\AI\AIProviderInterface;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class AdminDashboardService
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AdminAnalyticsService $analytics,
        private readonly SystemHealthService $health,
        private readonly AiConfigService $aiConfigService,
        private readonly AIProviderInterface $provider,
    ) {}

    /**
     * Build the permission-aware dashboard data for an administrator.
     *
     * @return array<string, mixed>
     */
    public function build(Administrator $administrator, string $range = '30d'): array
    {
        $since = $this->since($range);

        $data = [
            'range' => $range,
            'rangeLabel' => $this->rangeLabel($range),
            'kpis' => [],
            'quoteTrend' => [],
            'aiTrend' => [],
            'trafficTrend' => [],
            'topPages' => [],
            'recentQuotes' => null,
            'recentActivity' => null,
            'securityEvents' => [],
            'systemHealth' => $this->health->check(),
            'chatbotStatus' => null,
            'aiStatus' => null,
            'warnings' => [],
            'quickActions' => $this->quickActions($administrator),
        ];

        if ($administrator->hasPermission('analytics.view')) {
            $data['kpis']['visitors'] = PageView::where('viewed_at', '>=', $since)->distinct('visitor_id')->count('visitor_id');
            $data['kpis']['page_views'] = PageView::where('viewed_at', '>=', $since)->count();
            $data['trafficTrend'] = $this->analytics->trafficDaily($this->days($range));
            $data['topPages'] = $this->analytics->trafficTopPages($this->days($range), 5);
        }

        if ($administrator->hasPermission('quotes.view')) {
            $data['kpis']['quotes'] = QuoteSubmission::where('created_at', '>=', $since)->count();
            $data['quoteTrend'] = $this->analytics->quotesDaily($this->days($range));
            $data['recentQuotes'] = QuoteSubmission::query()
                ->orderByDesc('id')
                ->limit(5)
                ->get(['id', 'reference', 'status', 'contact_name', 'submitted_at']);
        }

        if ($administrator->hasPermission('chatbot.view')) {
            $data['kpis']['conversations'] = $this->analytics->chatbotStats()['conversations'];
            $data['chatbotStatus'] = ['enabled' => $this->aiConfigService->enabled() && $this->aiConfigService->assistantEnabled()];
        }

        if ($administrator->hasPermission('ai.view')) {
            $data['kpis']['ai_requests'] = $this->analytics->aiMetrics()['total_requests'];
            $data['aiTrend'] = $this->analytics->aiDaily($this->days($range));
            $data['aiStatus'] = [
                'enabled' => $this->aiConfigService->assistantEnabled() || $this->aiConfigService->quoteEnabled(),
                'configured' => $this->provider->isConfigured(),
                'provider' => $this->provider->name(),
            ];
            $data['warnings'] = array_merge($data['warnings'], $this->aiWarnings());
        }

        if ($administrator->hasPermission('audit.view')) {
            $data['recentActivity'] = $this->auditService->recent(6);
            $data['securityEvents'] = $this->securityEvents($since, 10);
        }

        $data['warnings'] = array_merge($data['warnings'], $this->generalWarnings());

        return $data;
    }

    /**
     * @return array<int, mixed>
     */
    private function securityEvents(CarbonInterface $from, int $limit): array
    {
        return AdminAuditLog::query()
            ->with('administrator:id,name,email')
            ->where('created_at', '>=', $from)
            ->whereIn('action', [
                'admin.login',
                'admin.login.failed',
                'security.password_change',
                'administrators.create',
                'administrators.disable',
                'administrators.enable',
            ])
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->all();
    }

    /**
     * @return array<int, string>
     */
    private function aiWarnings(): array
    {
        $warnings = [];

        if ($this->aiConfigService->enabled() && ! $this->provider->isConfigured()) {
            $warnings[] = 'The AI service is enabled but no provider key is configured.';
        }

        return $warnings;
    }

    /**
     * @return array<int, string>
     */
    private function generalWarnings(): array
    {
        $warnings = [];

        $mailer = (string) config('mail.default');

        if ($mailer === 'log' || $mailer === 'array') {
            $warnings[] = 'Email is running in log mode; contact forms and security notifications are not actually delivered.';
        } elseif ($mailer === 'smtp') {
            $password = (string) config('mail.mailers.smtp.password', '');

            if ($password === '') {
                $warnings[] = 'SMTP mailer is selected but no password is configured; transactional emails will fail.';
            }
        }

        return $warnings;
    }

    /**
     * @return array<int, array{label: string, href: string, icon: string}>
     */
    private function quickActions(Administrator $administrator): array
    {
        $actions = [];

        if ($administrator->hasPermission('quotes.view')) {
            $actions[] = ['label' => 'Review quotes', 'href' => route('admin.quotes.index'), 'icon' => 'clipboard-document-list'];
        }

        if ($administrator->hasPermission('portfolio.create')) {
            $actions[] = ['label' => 'Add portfolio project', 'href' => route('admin.portfolio.create'), 'icon' => 'briefcase'];
        }

        if ($administrator->hasPermission('settings.update')) {
            $actions[] = ['label' => 'Edit website settings', 'href' => route('admin.settings.index', ['group' => 'general']), 'icon' => 'globe-alt'];
        }

        if ($administrator->hasPermission('ai.view')) {
            $actions[] = ['label' => 'Open AI console', 'href' => route('admin.ai.dashboard'), 'icon' => 'sparkles'];
        }

        if ($administrator->hasPermission('audit.view')) {
            $actions[] = ['label' => 'View audit log', 'href' => route('admin.audit.index'), 'icon' => 'shield-check'];
        }

        return $actions;
    }

    private function since(string $range): Carbon
    {
        return match ($range) {
            'today' => now()->startOfDay(),
            'yesterday' => now()->startOfDay()->subDay(),
            '7d' => now()->startOfDay()->subDays(6),
            '90d' => now()->startOfDay()->subDays(89),
            default => now()->startOfDay()->subDays(29),
        };
    }

    private function days(string $range): int
    {
        return match ($range) {
            'today' => 1,
            'yesterday' => 2,
            '7d' => 7,
            '90d' => 90,
            default => 30,
        };
    }

    private function rangeLabel(string $range): string
    {
        return match ($range) {
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            '7d' => 'Last 7 days',
            '90d' => 'Last 90 days',
            default => 'Last 30 days',
        };
    }
}
