<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    private const ACTIVITY_KEY = 'admin_last_activity';

    public function handle(Request $request, Closure $next): Response
    {
        Auth::shouldUse('admin');

        $administrator = Auth::guard('admin')->user();

        if ($administrator === null) {
            return redirect()->guest(route('admin.login'));
        }

        if (! $administrator->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your account is disabled. Contact a Super Admin.']);
        }

        if ($this->sessionExpired($request)) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your session expired. Please sign in again.']);
        }

        $request->session()->put(self::ACTIVITY_KEY, now()->timestamp);

        return $next($request);
    }

    private function sessionExpired(Request $request): bool
    {
        $lifetime = (int) config('admin.session_lifetime_minutes', 120);

        if ($lifetime <= 0) {
            return false;
        }

        $lastActivity = $request->session()->get(self::ACTIVITY_KEY);

        if ($lastActivity === null) {
            return false;
        }

        return (int) $lastActivity < (now()->timestamp - ($lifetime * 60));
    }
}
