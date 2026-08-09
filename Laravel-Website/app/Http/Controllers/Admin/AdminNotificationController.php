<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function __construct(private readonly AdminNotificationService $notifications) {}

    public function index(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        return view('admin.notifications.index', [
            'administrator' => $administrator,
            'events' => $this->notifications->events(),
            'preferences' => $this->notifications->preferencesFor($administrator),
            'recentNotifications' => AdminNotification::query()
                ->with('administrator:id,name,email')
                ->orderByDesc('id')
                ->limit(20)
                ->get(),
        ]);
    }

    public function update(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        $enabled = array_fill_keys(array_keys($this->notifications->events()), false);
        $enabled = array_merge($enabled, array_fill_keys(array_keys($request->input('events', [])), true));

        $this->notifications->savePreferences($administrator, $enabled);

        return back()->with('status', 'Notification preferences updated.');
    }
}
