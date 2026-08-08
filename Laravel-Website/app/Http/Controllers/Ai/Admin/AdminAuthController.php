<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\Admin\AdminLoginRequest;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (! (bool) config('ai.admin.enabled')) {
            abort(404);
        }

        if ($request->session()->get(config('ai.admin.session_key')) === true) {
            return redirect()->route('admin.ai.dashboard');
        }

        return view('admin.ai.login');
    }

    public function login(AdminLoginRequest $request)
    {
        if (! (bool) config('ai.admin.enabled')) {
            abort(404);
        }

        $email = config('ai.admin.email');
        $password = config('ai.admin.password');

        $validEmail = $email !== null
            && strtolower((string) $request->validated('email')) === strtolower((string) $email);

        $validPassword = is_string($password)
            && $password !== ''
            && hash_equals((string) $password, (string) $request->validated('password'));

        if (! $validEmail || ! $validPassword) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput($request->only('email'));
        }

        $request->session()->put(config('ai.admin.session_key'), true);
        $request->session()->regenerate();

        return redirect()->route('admin.ai.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(config('ai.admin.session_key'));
        $request->session()->regenerate();

        return redirect()->route('admin.ai.login');
    }
}
