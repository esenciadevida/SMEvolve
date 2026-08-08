<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use App\Services\Admin\AdminDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AdminDashboardService $dashboardService,
        private readonly AdminAnalyticsService $analyticsService,
    ) {
    }

    public function index(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        $data = $this->dashboardService->build($administrator);

        $data['quoteTrend'] = $administrator->hasPermission('quotes.view')
            ? $this->analyticsService->quotesDaily(14)
            : [];

        $data['aiTrend'] = $administrator->hasPermission('ai.view')
            ? $this->analyticsService->aiDaily(14)
            : [];

        return view('admin.dashboard', $data);
    }
}
