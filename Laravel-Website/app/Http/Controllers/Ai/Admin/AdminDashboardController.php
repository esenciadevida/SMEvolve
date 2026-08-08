<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Services\AI\AiConfigService;
use App\Services\AI\AiUsageService;
use App\Services\AI\AIProviderInterface;
use App\Services\AI\HandoffService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AiUsageService $usageService,
        private readonly AiConfigService $configService,
        private readonly AIProviderInterface $provider,
        private readonly HandoffService $handoffService,
    ) {
    }

    public function index(Request $request)
    {
        $metrics = $this->usageService->metrics($request->boolean('last_7_days') ? now()->subDays(7) : null);

        return view('admin.ai.dashboard', [
            'metrics' => $metrics,
            'assistantEnabled' => $this->configService->assistantEnabled(),
            'quoteEnabled' => $this->configService->quoteEnabled(),
            'providerConfigured' => $this->provider->isConfigured(),
            'providerName' => $this->provider->name(),
            'openHandoffs' => $this->handoffService->openRequests(),
            'recentUsage' => $this->usageService->recent(10),
        ]);
    }
}
