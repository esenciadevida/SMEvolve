<?php

namespace App\Services\Content;

use App\Data\ValuesData;
use App\Models\ContentItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Reads admin-manageable content for the public site.
 *
 * The database is the source of truth once the ContentSeeder has populated
 * the content_items table. When the table is missing or contains no items
 * for a type (for example before seeding, or in tests), the original
 * code/config source is returned so the site keeps working exactly as before.
 */
class ContentService
{
    /**
     * @var array<string, Collection<int, array<string, mixed>>>
     */
    private array $cache = [];

    /**
     * Services shown on the Services page and homepage.
     *
     * @return array<int, array<string, mixed>>
     */
    public function services(): array
    {
        return $this->mapped('service', fn (ContentItem $item) => [
            'slug' => $item->slug,
            'name' => $item->title,
            'icon' => $item->icon,
            'description' => $item->description,
            'homepage' => (bool) ($item->data['homepage'] ?? false),
        ])->values()->all();
    }

    /**
     * Industry cards shown on the homepage.
     *
     * @return array<int, array<string, mixed>>
     */
    public function industries(): array
    {
        return $this->mapped('industry', fn (ContentItem $item) => [
            'title' => $item->title,
            'description' => $item->description,
            'icon' => $item->icon,
            'url' => $item->data['url'] ?? null,
            'solutions' => $item->data['solutions'] ?? [],
        ])->values()->all();
    }

    /**
     * Benefit cards used by the "Why Choose Us" section.
     *
     * @return array<int, array<string, mixed>>
     */
    public function benefits(): array
    {
        return $this->mapped('benefit', fn (ContentItem $item) => [
            'title' => $item->title,
            'description' => $item->description,
            'icon' => $item->icon,
        ])->values()->all();
    }

    /**
     * Company values shown on the About page.
     *
     * @return array<int, array<string, mixed>>
     */
    public function values(): array
    {
        return $this->mapped('value', fn (ContentItem $item) => [
            'title' => $item->title,
            'description' => $item->description,
            'icon' => $item->icon,
        ])->values()->all();
    }

    /**
     * FAQ items in the same shape as config('faqs.items').
     *
     * @return array<int, array<string, mixed>>
     */
    public function faqs(): array
    {
        return $this->mapped('faq', function (ContentItem $item) {
            $tags = $item->data['tags'] ?? [];
            $category = $item->data['category'] ?? 'general';

            return [
                'id' => $item->slug,
                'tag' => $item->data['tag'] ?? $category,
                'category' => $category,
                'question' => $item->title,
                'answer' => $item->description,
                'tags' => is_array($tags) ? $tags : [$tags],
                'priority' => (int) ($item->data['priority'] ?? 10),
                'featured' => (bool) ($item->data['featured'] ?? false),
                'related_pages' => [],
                'status' => $item->data['status'] ?? 'active',
            ];
        })->values()->all();
    }

    /**
     * Website package cards shown on the Packages page.
     *
     * @return array<int, array<string, mixed>>
     */
    public function packages(): array
    {
        return $this->mapped('package', fn (ContentItem $item) => [
            'slug' => $item->slug,
            'name' => $item->title,
            'description' => $item->description,
            'target_audience' => $item->data['audience'] ?? [],
            'features' => $item->data['features'] ?? [],
            'starting_price' => null,
            'badge' => $item->data['badge'] ?? null,
            'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
        ])->values()->all();
    }

    /**
     * Map published database items for a type into the public content shape,
     * falling back to the original source when the table has no rows.
     *
     * @param  callable(ContentItem): array<string, mixed>  $mapper
     * @return Collection<int, array<string, mixed>>
     */
    private function mapped(string $type, callable $mapper): Collection
    {
        if (isset($this->cache[$type])) {
            return $this->cache[$type];
        }

        if (! Schema::hasTable((new ContentItem)->getTable())) {
            return $this->cache[$type] = collect($this->fallback($type));
        }

        $items = ContentItem::query()
            ->where('type', $type)
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($items->isNotEmpty()) {
            return $this->cache[$type] = $items->map($mapper);
        }

        return $this->cache[$type] = collect($this->fallback($type));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fallback(string $type): array
    {
        return match ($type) {
            'service' => config('website.services', []),
            'industry' => config('industries', []),
            'benefit' => config('benefits', []),
            'value' => (new ValuesData)->all(),
            'faq' => config('faqs.items', []),
            'package' => config('packages.website_packages.items', []),
            default => [],
        };
    }
}
