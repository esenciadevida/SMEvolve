<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\Contact\ContactSubmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        session(['contact_token' => Str::random(40)]);

        return view('pages.contact');
    }

    public function store(ContactRequest $request, ContactSubmissionService $service): RedirectResponse
    {
        $token = $request->input('contact_token');
        $sessionToken = (string) session('contact_token', '');

        if (! is_string($token) || ! hash_equals($sessionToken, $token)) {
            return back()
                ->withErrors(['contact_token' => 'Your session has expired. Please refresh the page and try again.'])
                ->withInput();
        }

        $service->submit($request->validated());

        session()->forget('contact_token');

        return redirect()->route('contact')->with('contact_success', true);
    }
}
