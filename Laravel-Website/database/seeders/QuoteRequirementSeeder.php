<?php

namespace Database\Seeders;

use App\Models\QuoteRequirement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuoteRequirementSeeder extends Seeder
{
    /**
     * Populate the quote requirements catalog from configuration.
     */
    public function run(): void
    {
        $sortOrder = 0;

        foreach (config('quote.features', []) as $projectType => $features) {
            foreach ($features as $feature) {
                $key = (string) ($feature['key'] ?? '');

                if ($key === '') {
                    continue;
                }

                QuoteRequirement::updateOrCreate(
                    ['key' => $key],
                    [
                        'name' => (string) ($feature['label'] ?? Str::headline($key)),
                        'category' => $feature['category'] ?? null,
                        'sort_order' => $sortOrder++,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
