<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminHasPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $administrator = Auth::guard('admin')->user();

        if ($administrator === null) {
            return redirect()->guest(route('admin.login'));
        }

        if (! $administrator->is_active) {
            abort(403, 'This account is disabled.');
        }

        foreach ($permissions as $permission) {
            if ($administrator->hasPermission($permission)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to perform this action.');
    }
}
