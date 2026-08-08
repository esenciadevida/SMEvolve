<?php

namespace Database\Factories;

use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioProject>
 */
class PortfolioProjectFactory extends Factory
{
    protected $model = PortfolioProject::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portfolio_category_id' => PortfolioCategory::factory(),
            'slug' => $this->faker->unique()->slug(3),
            'title' => $this->faker->sentence(4),
            'status' => 'Delivered 2026',
            'featured' => false,
            'image' => null,
            'industry' => $this->faker->words(2, true),
            'project_type' => 'Web Application',
            'summary' => $this->faker->paragraph(),
            'short_description' => $this->faker->sentence(),
            'sort_order' => 0,
            'is_published' => true,
            'services' => [],
            'services_slugs' => [],
            'technologies' => ['Laravel', 'MySQL'],
            'gallery' => null,
            'challenge' => null,
            'solution' => null,
            'features' => null,
            'outcome' => null,
            'meta' => null,
        ];
    }
}
