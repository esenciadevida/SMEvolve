<?php

namespace Database\Factories;

use App\Models\PortfolioCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioCategory>
 */
class PortfolioCategoryFactory extends Factory
{
    protected $model = PortfolioCategory::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(2),
            'name' => $this->faker->words(2, true),
            'icon' => 'rectangle-stack',
            'description' => $this->faker->sentence(),
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
