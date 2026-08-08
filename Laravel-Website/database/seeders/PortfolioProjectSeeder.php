<?php

namespace Database\Seeders;

use App\Data\Portfolio\Projects\ConceptClinicWebsite;
use App\Data\Portfolio\Projects\ConceptRetailStore;
use App\Data\Portfolio\Projects\SampleInventorySystem;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Database\Seeder;

class PortfolioProjectSeeder extends Seeder
{
    /**
     * Seed the sample portfolio projects from the code providers into the
     * database so the Admin Portal and the public site show the same content.
     * The samples are clearly labelled and can be edited or deleted from the
     * Admin Portal.
     */
    public function run(): void
    {
        $providers = [
            new SampleInventorySystem(),
            new ConceptClinicWebsite(),
            new ConceptRetailStore(),
        ];

        foreach ($providers as $index => $provider) {
            $content = $provider->content();

            PortfolioProject::updateOrCreate(
                ['slug' => $content['slug']],
                [
                    'portfolio_category_id' => PortfolioCategory::where('slug', $content['categorySlug'] ?? null)->value('id'),
                    'title' => $content['title'],
                    'status' => $content['status'] ?? 'Sample Project',
                    'featured' => (bool) ($content['featured'] ?? false),
                    'image' => $content['image'] ?? null,
                    'industry' => $content['industry'] ?? null,
                    'project_type' => $content['projectType'] ?? null,
                    'summary' => $content['summary'] ?? null,
                    'short_description' => $content['shortDescription'],
                    'sort_order' => $index,
                    'is_published' => true,
                    'services' => $content['services'] ?? [],
                    'services_slugs' => $content['servicesSlugs'] ?? [],
                    'technologies' => $content['technologies'] ?? [],
                    'gallery' => $content['gallery'] ?? null,
                    'challenge' => $content['challenge'] ?? null,
                    'solution' => $content['solution'] ?? null,
                    'features' => $content['features'] ?? null,
                    'outcome' => $content['outcome'] ?? null,
                    'meta' => $content['meta'] ?? null,
                ]
            );
        }
    }
}
