<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnalyticsController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analytics) {}

    public function index()
    {
        return redirect()->route('admin.analytics.traffic');
    }

    public function traffic(Request $request)
    {
        $days = $this->days($request);

        return view('admin.analytics.traffic', [
            'days' => $days,
            'summary' => $this->analytics->trafficSummary($days),
            'trend' => $this->analytics->trafficDaily($days),
            'topPages' => $this->analytics->trafficTopPages($days),
            'topReferrers' => $this->analytics->trafficTopReferrers($days),
            'devices' => $this->analytics->trafficDeviceBreakdown($days),
            'browsers' => $this->analytics->trafficBrowserBreakdown($days),
            'oss' => $this->analytics->trafficOsBreakdown($days),
        ]);
    }

    public function quotes()
    {
        $this->authorizeOrAbort('quotes.view');

        return view('admin.analytics.quotes', [
            'quoteMetrics' => $this->analytics->quoteMetrics(),
            'quoteTrend' => $this->analytics->quotesDaily(30),
            'quoteStatus' => $this->analytics->quoteStatusCounts(),
            'funnel' => $this->analytics->quoteFunnel(),
        ]);
    }

    public function chatbot()
    {
        $this->authorizeOrAbort('chatbot.view');

        return view('admin.analytics.chatbot', [
            'chatbot' => $this->analytics->chatbotStats(),
            'activity' => [],
        ]);
    }

    public function ai()
    {
        $this->authorizeOrAbort('ai.view');

        return view('admin.analytics.ai', [
            'aiMetrics' => $this->analytics->aiMetrics(),
            'aiTrend' => $this->analytics->aiDaily(30),
            'aiEndpoints' => $this->analytics->aiEndpointStats(),
            'aiModels' => $this->analytics->aiModelStats(),
        ]);
    }

    private function authorizeOrAbort(string $permission): void
    {
        $administrator = Auth::guard('admin')->user();

        if (! $administrator?->hasPermission($permission)) {
            abort(403, 'You do not have permission to view this analytics section.');
        }
    }

    private function days(Request $request): int
    {
        $days = $request->integer('days', 30);

        return in_array($days, [7, 14, 30, 90], true) ? $days : 30;
    }
}
