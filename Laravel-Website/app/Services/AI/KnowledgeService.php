<?php

namespace App\Services\AI;

use App\Data\ServicesData;
use App\Models\KnowledgeItem;
use App\Services\Content\ContentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KnowledgeService
{
    public function __construct(
        private readonly ServicesData $servicesData,
        private readonly ContentService $content,
    ) {
    }

    /**
     * Build the full knowledge context for an AI request.
     */
    public function contextFor(string $query, int $limit = 8): string
    {
        $blocks = [
            $this->companyBlock(),
            $this->servicesBlock(),
            $this->packagesBlock(),
            $this->faqBlock(),
            $this->searchKnowledge($query, $limit)->implode("\n\n"),
        ];

        return implode("\n\n", array_filter($blocks));
    }

    public function companyBlock(): string
    {
        $company = config('company', []);
        $contact = $company['contact'] ?? [];
        $hours = $company['hours'] ?? [];

        $lines = [
            'COMPANY',
            'Name: '.($company['name'] ?? null),
            'Tagline: '.($company['tagline'] ?? null),
            'Description: '.($company['description'] ?? null),
            'Email: '.($contact['email'] ?? null),
            'Phone: '.($contact['phone'] ?? null),
            'WhatsApp: '.($contact['whatsapp'] ?? null),
            'Hours: '.($hours['summary_string'] ?? null),
            'Service area: '.($company['service_area']['introduction'] ?? null),
        ];

        return implode("\n", array_filter($lines, fn ($line) => $line !== null && $line !== ''));
    }

    public function servicesBlock(): string
    {
        $catalog = $this->servicesData->catalog();

        $lines = $catalog->map(function (array $service) {
            $details = '';
            if (isset($service['overview']['description'])) {
                $details = ', '.$service['overview']['description'];
            }

            return "- {$service['name']}: {$service['description']}{$details}";
        });

        return implode("\n", array_filter([
            'SERVICES',
            ...$lines->all(),
        ]));
    }

    public function packagesBlock(): string
    {
        $websitePackages = $this->content->packages();

        $lines = collect($websitePackages)->map(function (array $package) {
            $features = implode(', ', $package['features'] ?? []);
            $audience = implode(', ', $package['target_audience'] ?? []);

            return "- {$package['name']} ({$package['slug']}): {$package['description']} Ideal for: {$audience}. Features: {$features}.";
        });

        $custom = collect(config('packages.custom_solutions.services', []))->map(function (array $service) {
            $examples = implode(', ', $service['examples'] ?? []);

            return "- {$service['name']}: {$service['description']} Examples: {$examples}.";
        });

        $recommended = config('packages.website_packages.recommended');

        return implode("\n", array_filter([
            'PACKAGES',
            "Recommended website package: {$recommended}.",
            ...$lines->all(),
            'CUSTOM SOLUTIONS',
            ...$custom->all(),
        ]));
    }

    public function faqBlock(int $limit = 12): string
    {
        $faqs = collect($this->content->faqs())
            ->where('status', 'active')
            ->sortBy('priority')
            ->take($limit);

        $lines = $faqs->map(fn (array $faq) => "Q: {$faq['question']}\nA: {$faq['answer']}");

        return implode("\n", array_filter([
            'FREQUENTLY ASKED QUESTIONS',
            ...$lines->all(),
        ]));
    }

    /**
     * Search published knowledge items ranked by keyword overlap.
     *
     * @return Collection<int, string>
     */
    public function searchKnowledge(string $query, int $limit = 8): Collection
    {
        $items = KnowledgeItem::where('status', 'published')
            ->get()
            ->map(fn (KnowledgeItem $item) => [
                'item' => $item,
                'score' => $this->score($item, $query),
            ])
            ->filter(fn (array $row) => $row['score'] > 0)
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        return $items->map(function (array $row) {
            $item = $row['item'];

            return "KNOWLEDGE: {$item->title}\n{$item->content}";
        });
    }

    private function score(KnowledgeItem $item, string $query): int
    {
        $query = mb_strtolower(trim($query));

        if ($query === '') {
            return 0;
        }

        $haystack = mb_strtolower(
            $item->title.' '.$item->content.' '.implode(' ', (array) ($item->metadata['keywords'] ?? []))
        );

        $score = 0;

        foreach (Str::of($query)->split('/[\s,\.\-_]+/') as $term) {
            $term = (string) $term;
            if (mb_strlen($term) < 3) {
                continue;
            }

            if (Str::contains($haystack, $term)) {
                $score += 2;
            }

            if (Str::contains(mb_strtolower($item->title), $term)) {
                $score += 3;
            }
        }

        if (Str::contains($haystack, $query)) {
            $score += 5;
        }

        return $score;
    }
}
