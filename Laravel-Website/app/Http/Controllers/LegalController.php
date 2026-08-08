<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * The Privacy Policy page.
     */
    public function privacy(): View
    {
        return $this->render('privacy-policy');
    }

    /**
     * The Terms & Conditions page.
     */
    public function terms(): View
    {
        return $this->render('terms');
    }

    /**
     * The Cookie Policy page.
     */
    public function cookies(): View
    {
        return $this->render('cookies');
    }

    /**
     * Load a legal document from configuration and render it through the
     * shared legal page template.
     *
     * @param  string  $key  The document key in config('legal.documents').
     */
    private function render(string $key): View
    {
        $document = collect(config('legal.documents', []))
            ->first(fn ($item) => ($item['key'] ?? null) === $key
                && ($item['status'] ?? 'active') === 'active');

        abort_unless($document, 404, 'Legal document not found.');

        return view('pages.legal', ['document' => $document]);
    }
}
