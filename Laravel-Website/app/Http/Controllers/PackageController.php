<?php

namespace App\Http\Controllers;

use App\Services\Content\ContentService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(ContentService $content): View
    {
        return view('pages.packages', [
            'hero' => config('packages.hero', []),
            'philosophy' => config('packages.philosophy', []),
            'websitePackages' => [
                ...config('packages.website_packages', []),
                'items' => $content->packages(),
            ],
            'customSolutions' => config('packages.custom_solutions', []),
            'comparison' => config('packages.comparison', []),
            'faqSection' => config('packages.faqs', []),
            'faqItems' => $this->faqItems($content),
        ]);
    }

    /**
     * Curated subset of the shared FAQ dataset tagged for packages.
     */
    private function faqItems(ContentService $content): Collection
    {
        $tag = config('packages.faqs.tag', 'packages');
        $take = (int) config('packages.faqs.take', 6);

        return collect($content->faqs())
            ->where('status', 'active')
            ->where('tag', $tag)
            ->values()
            ->take($take);
    }
}
