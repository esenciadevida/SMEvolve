<?php

namespace Database\Seeders;

use App\Data\ServicesData;
use App\Models\KnowledgeItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedServices();
        $this->seedPackages();
        $this->seedFaqs();
    }

    private function seedServices(): void
    {
        $services = new ServicesData;

        foreach ($services->catalog() as $service) {
            $description = $service['description'] ?? '';
            $overview = $service['overview']['description'] ?? null;

            if ($overview !== null) {
                $description = $overview;
            }

            $summary = $this->summarize($description);

            if ($summary === null) {
                continue;
            }

            KnowledgeItem::updateOrCreate(
                ['type' => 'service', 'slug' => $service['slug']],
                [
                    'title' => $service['name'],
                    'content' => $summary,
                    'status' => 'published',
                    'priority' => 'normal',
                    'metadata' => ['keywords' => $this->keywordsFrom($service['name'], $description)],
                    'created_by' => 'system',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function seedPackages(): void
    {
        foreach (config('packages.website_packages.items', []) as $package) {
            $summary = $this->summarize(trim(
                ($package['description'] ?? '')
                .' Features: '.implode(', ', $package['features'] ?? [])
                .' Ideal for: '.implode(', ', $package['target_audience'] ?? [])
            ));

            if ($summary === null) {
                continue;
            }

            KnowledgeItem::updateOrCreate(
                ['type' => 'package', 'slug' => $package['slug']],
                [
                    'title' => $package['name'],
                    'content' => $summary,
                    'status' => 'published',
                    'priority' => 'normal',
                    'metadata' => ['keywords' => $this->keywordsFrom($package['name'], $summary)],
                    'created_by' => 'system',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function seedFaqs(): void
    {
        foreach (config('faqs.items', []) as $faq) {
            if (($faq['status'] ?? '') !== 'active') {
                continue;
            }

            $content = "Q: {$faq['question']}\nA: {$faq['answer']}";

            KnowledgeItem::updateOrCreate(
                ['type' => 'faq', 'slug' => $faq['id']],
                [
                    'title' => $faq['question'],
                    'content' => $content,
                    'status' => 'published',
                    'priority' => $faq['priority'] <= 3 ? 'high' : 'normal',
                    'metadata' => ['keywords' => $faq['tags'] ?? []],
                    'created_by' => 'system',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function summarize(string $text): ?string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($text === '') {
            return null;
        }

        return Str::limit($text, 800);
    }

    private function keywordsFrom(string $title, string $description): array
    {
        $words = array_values(array_filter(array_map(
            fn ($word) => mb_strtolower($word),
            preg_split('/[\s,\.;:]+/', $title.' '.$description) ?: []
        )));

        return array_slice(array_unique(array_filter($words, fn ($word) => mb_strlen($word) > 3)), 0, 12);
    }
}
