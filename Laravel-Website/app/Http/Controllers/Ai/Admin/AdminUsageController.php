<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\QuoteSession;
use App\Services\AI\AiConfigService;
use App\Services\AI\AIProviderInterface;
use App\Services\AI\AiUsageService;

class AdminUsageController extends Controller
{
    public function __construct(
        private readonly AiUsageService $usageService,
        private readonly AIProviderInterface $provider,
        private readonly AiConfigService $configService,
    ) {}

    public function index()
    {
        return view('admin.ai.usage', [
            'metrics' => $this->usageService->metrics(now()->subDays(30)),
            'metricsToday' => $this->usageService->metrics(now()->startOfDay()),
            'topEndpoints' => $this->usageService->topEndpoints(),
            'recentUsage' => $this->usageService->recent(50),
            'conversationCount' => Conversation::withTrashed()->count(),
            'quoteSessionCount' => QuoteSession::withTrashed()->count(),
        ]);
    }

    public function health()
    {
        return view('admin.ai.health', [
            'providerConfigured' => $this->provider->isConfigured(),
            'providerName' => $this->provider->name(),
            'model' => $this->configService->model(),
            'baseUrl' => config('ai.groq.base_url'),
            'timeout' => config('ai.groq.timeout'),
            'assistantEnabled' => $this->configService->assistantEnabled(),
            'quoteEnabled' => $this->configService->quoteEnabled(),
            'limits' => config('ai.limits'),
            'rateLimits' => config('ai.rate_limits'),
        ]);
    }
}
