<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnalyticsController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analytics) {}

    public function index(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        $data = [
            'quoteMetrics' => null,
            'quoteTrend' => [],
            'quoteStatus' => [],
            'funnel' => [],
            'aiMetrics' => null,
            'aiTrend' => [],
            'aiEndpoints' => [],
            'aiModels' => [],
            'chatbot' => null,
            'activity' => [],
        ];

        if ($administrator->hasPermission('quotes.view')) {
            $data['quoteMetrics'] = $this->analytics->quoteMetrics();
            $data['quoteTrend'] = $this->analytics->quotesDaily(30);
            $data['quoteStatus'] = $this->analytics->quoteStatusCounts();
            $data['funnel'] = $this->analytics->quoteFunnel();
        }

        if ($administrator->hasPermission('ai.view')) {
            $data['aiMetrics'] = $this->analytics->aiMetrics();
            $data['aiTrend'] = $this->analytics->aiDaily(14);
            $data['aiEndpoints'] = $this->analytics->aiEndpointStats();
            $data['aiModels'] = $this->analytics->aiModelStats();
        }

        if ($administrator->hasPermission('chatbot.view')) {
            $data['chatbot'] = $this->analytics->chatbotStats();
        }

        if ($administrator->hasPermission('audit.view')) {
            $data['activity'] = $this->analytics->adminActivityDaily(14);
        }

        return view('admin.analytics', $data);
    }
}
