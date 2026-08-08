<?php

namespace App\Providers;

use App\Data\Portfolio\PortfolioData;
use App\Services\Content\ContentService;
use App\Services\Search\FaqSearchProvider;
use App\Services\Search\PackageSearchProvider;
use App\Services\Search\PageSearchProvider;
use App\Services\Search\PortfolioSearchProvider;
use App\Services\Search\PublicSearchResourceRegistry;
use App\Services\Search\PublicSearchService;
use App\Services\Search\ServiceSearchProvider;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PublicSearchService::class);

        $this->app->singleton(PublicSearchResourceRegistry::class, function () {
            $registry = new PublicSearchResourceRegistry;

            $registry->register(new ServiceSearchProvider(app(ContentService::class)));
            $registry->register(new PackageSearchProvider(app(ContentService::class)));
            $registry->register(new PortfolioSearchProvider(app(PortfolioData::class)));
            $registry->register(new FaqSearchProvider(app(ContentService::class)));
            $registry->register(new PageSearchProvider);

            return $registry;
        });
    }

    public function boot(): void
    {
        //
    }
}
