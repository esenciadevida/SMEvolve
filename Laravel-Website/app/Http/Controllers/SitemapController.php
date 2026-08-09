<?php

namespace App\Http\Controllers;

use App\Data\Portfolio\PortfolioData;
use App\Data\ServicesData;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function __construct(
        private readonly ServicesData $services,
        private readonly PortfolioData $portfolio,
        private readonly CacheRepository $cache,
    ) {}

    /**
     * Serve the XML sitemap for indexable public pages only.
     */
    public function index(Request $request): Response
    {
        $ttl = max(60, (int) config('seo.sitemap.cache_ttl', 3600));

        $xml = $this->cache->remember('sitemap.xml', $ttl, function (): string {
            return $this->build();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age='.$ttl.', s-maxage='.$ttl,
        ]);
    }

    /**
     * Build the urlset for every URL genuinely intended for indexing.
     * No fabricated dates, changefreq, or priority values are emitted.
     */
    private function build(): string
    {
        $urls = [];

        foreach (config('seo.sitemap.static_routes', []) as $routeName) {
            if (Route::has($routeName)) {
                $urls[] = route($routeName);
            }
        }

        foreach ($this->services->catalog() as $service) {
            $urls[] = route('services.show', $service['slug']);
        }

        foreach ($this->portfolio->categories() as $category) {
            if (($category['projectCount'] ?? 0) > 0) {
                $urls[] = route('portfolio.category', $category['slug']);
            }
        }

        $entries = collect(array_unique($urls))
            ->map(fn (string $url) => ['loc' => $url])
            ->values();

        foreach ($this->portfolio->projects() as $project) {
            $entry = ['loc' => route('portfolio.show', $project['slug'])];

            if (filled($project['updated_at'] ?? null)) {
                $entry['lastmod'] = $project['updated_at'];
            }

            $entries->push($entry);
        }

        $lines = ['<?xml version="1.0" encoding="UTF-8"?>'];
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($entries as $entry) {
            $lines[] = '<url><loc>'.e($entry['loc']).'</loc>'
                .(isset($entry['lastmod']) ? '<lastmod>'.e($entry['lastmod']).'</lastmod>' : '')
                .'</url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
