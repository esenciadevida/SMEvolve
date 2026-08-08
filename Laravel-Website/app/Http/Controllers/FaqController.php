<?php

namespace App\Http\Controllers;

use App\Services\Content\ContentService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * The FAQ Knowledge Center page.
     *
     * Loads the shared FAQ dataset (single source of truth), filtered to
     * active entries, ordered by priority then alphabetically.
     */
    public function index(ContentService $content): View
    {
        $faqs = $this->activeFaqs($content);

        $categories = $this->categories($faqs);

        return view('pages.faq', [
            'meta' => config('faqs.meta', []),
            'faqs' => $faqs,
            'categories' => $categories,
        ]);
    }

    /**
     * Active FAQ entries sorted by priority (lowest number first) and then
     * alphabetically by question.
     *
     * @return array<int, array<string, mixed>>
     */
    private function activeFaqs(ContentService $content): array
    {
        return collect($content->faqs())
            ->filter(fn ($item) => ($item['status'] ?? 'active') === 'active')
            ->sortBy([
                fn ($item) => (int) ($item['priority'] ?? 10),
                fn ($item) => strtolower($item['question'] ?? ''),
            ])
            ->values()
            ->all();
    }

    /**
     * Config-driven categories enriched with the number of active FAQs in
     * each category.
     *
     * @param  array<int, array<string, mixed>>  $faqs
     * @return array<int, array<string, mixed>>
     */
    private function categories(array $faqs): array
    {
        $faqCollection = collect($faqs);

        return collect(config('faqs.categories', []))
            ->sortBy(fn ($category) => (int) ($category['display_order'] ?? 99))
            ->values()
            ->map(fn ($category) => [
                ...$category,
                'count' => $category['id'] === 'all'
                    ? $faqCollection->count()
                    : $faqCollection->where('category', $category['id'])->count(),
            ])
            ->all();
    }
}
