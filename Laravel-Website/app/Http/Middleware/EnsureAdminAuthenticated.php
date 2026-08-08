<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! (bool) config('ai.admin.enabled')) {
            abort(404);
        }

        if ($request->session()->get(config('ai.admin.session_key')) !== true) {
            return redirect()->route('admin.ai.login');
        }

        return $next($request);
    }
}
