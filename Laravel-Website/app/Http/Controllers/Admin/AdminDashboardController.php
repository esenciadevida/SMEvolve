<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __construct(private readonly AdminDashboardService $dashboardService) {}

    public function index(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        $range = $request->string('range')->trim()->value();
        $range = in_array($range, ['today', 'yesterday', '7d', '30d', '90d'], true) ? $range : '30d';

        return view('admin.dashboard', $this->dashboardService->build($administrator, $range));
    }
}
