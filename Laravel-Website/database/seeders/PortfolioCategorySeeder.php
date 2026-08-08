<?php

namespace Database\Seeders;

use App\Models\PortfolioCategory;
use Illuminate\Database\Seeder;

class PortfolioCategorySeeder extends Seeder
{
    /**
     * Seed the standard portfolio categories from the approved specification
     * (Documentation/08_Portfolio/05_Project_Categories.md).
     */
    public function run(): void
    {
        $categories = [
            ['slug' => 'websites', 'name' => 'Website Development', 'icon' => 'globe-alt', 'description' => 'Business websites, corporate sites, landing pages, and informational websites built to establish credibility and support growth.', 'sort_order' => 1],
            ['slug' => 'ecommerce', 'name' => 'E-commerce Development', 'icon' => 'shopping-cart', 'description' => 'Online stores and digital commerce platforms designed for a smooth shopping experience and reliable order management.', 'sort_order' => 2],
            ['slug' => 'custom-software', 'name' => 'Custom Software', 'icon' => 'rectangle-stack', 'description' => 'Business systems developed specifically for client requirements, from dashboards to full management platforms.', 'sort_order' => 3],
            ['slug' => 'mobile-apps', 'name' => 'Mobile Applications', 'icon' => 'device-mobile', 'description' => 'Native and cross-platform mobile applications designed to improve customer engagement and business operations.', 'sort_order' => 4],
            ['slug' => 'ai-solutions', 'name' => 'AI Solutions', 'icon' => 'cpu-chip', 'description' => 'Projects that use artificial intelligence to improve business operations or customer experiences.', 'sort_order' => 5],
            ['slug' => 'business-automation', 'name' => 'Business Automation', 'icon' => 'bolt', 'description' => 'Workflow automation and process optimisation projects that reduce manual work and improve efficiency.', 'sort_order' => 6],
            ['slug' => 'api-development', 'name' => 'API Development', 'icon' => 'code', 'description' => 'Projects focused on integrations and software communication, from payment gateways to third-party systems.', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            PortfolioCategory::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'is_published' => true,
                ]
            );
        }
    }
}
