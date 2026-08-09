<?php

namespace App\Data\Portfolio;

use App\Data\ServicesData;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PortfolioData
{
    /**
     * Project content providers.
     *
     * Database projects (when present) take precedence so portfolio
     * content is managed from the admin portal. The code providers remain
     * as a fallback for a fresh install with no projects yet.
     *
     * @return array<int, PortfolioProject|object>
     */
    public function providers(): array
    {
        $dbProjects = collect();

        if (Schema::hasTable((new PortfolioProject)->getTable())) {
            $dbProjects = PortfolioProject::query()
                ->with('category')
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        if ($dbProjects->isNotEmpty()) {
            return $dbProjects->all();
        }

        return [
            new Projects\SampleInventorySystem,
            new Projects\ConceptClinicWebsite,
            new Projects\ConceptRetailStore,
        ];
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function projects(): Collection
    {
        return collect($this->providers())
            ->map(fn ($provider) => $provider instanceof PortfolioProject ? $this->toArray($provider) : $provider->content())
            ->values();
    }

    /**
     * Map a database project to the array shape consumed by the public views.
     *
     * @return array<string, mixed>
     */
    private function toArray(PortfolioProject $project): array
    {
        return [
            'slug' => $project->slug,
            'title' => $project->title,
            'status' => $project->status,
            'featured' => (bool) $project->featured,
            'image' => $project->image,
            'category' => $project->category?->name,
            'categorySlug' => $project->category?->slug,
            'industry' => $project->industry,
            'projectType' => $project->project_type,
            'services' => $project->services ?? [],
            'servicesSlugs' => $project->services_slugs ?? [],
            'summary' => $project->summary,
            'shortDescription' => $project->short_description,
            'technologies' => $project->technologies ?? [],
            'gallery' => $project->gallery ?? [],
            'challenge' => $project->challenge ?? [],
            'solution' => $project->solution ?? [],
            'features' => $project->features ?? [],
            'outcome' => $project->outcome ?? [],
            'meta' => $project->meta ?? [],
            'updated_at' => $project->updated_at?->toIso8601String(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        return $this->projects()->firstWhere('slug', $slug);
    }

    /**
     * Summary entries used by project cards and grids.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function catalog(): Collection
    {
        return $this->projects()->map(fn (array $project) => [
            'title' => $project['title'],
            'slug' => $project['slug'],
            'category' => $project['category'],
            'categorySlug' => $project['categorySlug'],
            'status' => $project['status'],
            'featured' => $project['featured'] ?? false,
            'description' => $project['shortDescription'],
            'technologies' => $project['technologies'],
            'image' => $project['image'] ?? null,
            'url' => route('portfolio.show', $project['slug']),
        ]);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function featured(int $limit = 3): Collection
    {
        return $this->catalog()
            ->filter(fn (array $project) => $project['featured'])
            ->take($limit)
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function byCategory(string $categorySlug): Collection
    {
        return $this->catalog()
            ->filter(fn (array $project) => $project['categorySlug'] === $categorySlug)
            ->values();
    }

    /**
     * Projects related to a given slug: same category first, then others.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function related(string $slug, int $limit = 3): Collection
    {
        $current = $this->find($slug);

        return $this->catalog()
            ->filter(fn (array $project) => $project['slug'] !== $slug)
            ->sortBy(fn (array $project) => $project['categorySlug'] === ($current['categorySlug'] ?? null) ? 0 : 1)
            ->take($limit)
            ->values();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function prev(string $slug): ?array
    {
        return $this->sibling($slug, -1);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function next(string $slug): ?array
    {
        return $this->sibling($slug, 1);
    }

    /**
     * Resolve service catalog entries referenced by a project.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function relatedServices(array $project): Collection
    {
        $services = app(ServicesData::class)->catalog()->keyBy('slug');

        return collect($project['servicesSlugs'] ?? [])
            ->map(fn (string $slug) => $services->get($slug))
            ->filter()
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function categories(): Collection
    {
        $counts = $this->catalog()->groupBy('categorySlug')->map->count();

        return collect($this->categoryRows())
            ->map(function (array $category) use ($counts) {
                $category['projectCount'] = $counts[$category['slug']] ?? 0;

                return $category;
            })
            ->values();
    }

    /**
     * Category definitions. Database categories take precedence once populated
     * so they can be managed from the admin portal; the code list remains as
     * the fallback for a fresh install.
     *
     * @return array<int, array<string, mixed>>
     */
    private function categoryRows(): array
    {
        if (Schema::hasTable((new PortfolioCategory)->getTable())) {
            $categories = PortfolioCategory::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            if ($categories->isNotEmpty()) {
                return $categories->map(fn (PortfolioCategory $category) => [
                    'slug' => $category->slug,
                    'name' => $category->name,
                    'icon' => $category->icon,
                    'description' => $category->description,
                    'seoTitle' => $category->name,
                    'seoDescription' => $category->description,
                ])->all();
            }
        }

        return (new ProjectCategories)->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function category(string $slug): ?array
    {
        return $this->categories()->firstWhere('slug', $slug);
    }

    /**
     * Previous or next project in catalog order (wraps around).
     *
     * @return array<string, mixed>|null
     */
    private function sibling(string $slug, int $offset): ?array
    {
        $all = $this->catalog()->values();
        $index = $all->search(fn (array $project) => $project['slug'] === $slug);

        if ($index === false) {
            return null;
        }

        $count = $all->count();
        $target = ($index + $offset + $count) % $count;

        return $all->get($target);
    }
}
