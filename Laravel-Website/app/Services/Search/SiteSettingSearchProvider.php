<?php

namespace App\Services\Search;

use Illuminate\Support\Collection;

class SiteSettingSearchProvider extends AbstractSearchProvider
{
    /**
     * @var Collection<int, array{key: string, label: string, group: string}>|null
     */
    private ?Collection $candidates = null;

    public function __construct()
    {
        parent::__construct('settings', 'Settings', 'settings.view');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return $this->candidates()
            ->map(fn (array $setting) => [
                'setting' => $setting,
                'rank' => $this->rank($setting, $lower),
            ])
            ->filter(fn (array $item) => $item['rank'] !== null)
            ->sortBy(fn (array $item) => $item['rank'])
            ->take($limit)
            ->map(fn (array $item) => $item['setting'])
            ->values();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || ! isset($record['key'], $record['label'], $record['group'])) {
            return null;
        }

        return new SearchResult(
            type: 'setting',
            id: $record['key'],
            title: $record['label'],
            subtitle: $record['key'],
            url: route('admin.settings.index', ['group' => $record['group']]),
            metadata: [
                'key' => $record['key'],
                'group' => $record['group'],
            ],
        );
    }

    /**
     * Return a deterministic list of searchable system settings derived from
     * the admin settings configuration. Stored values are intentionally never
     * included so sensitive configuration cannot leak through search.
     *
     * @return Collection<int, array{key: string, label: string, group: string}>
     */
    private function candidates(): Collection
    {
        if ($this->candidates !== null) {
            return $this->candidates;
        }

        $candidates = collect();

        foreach ((array) config('admin.settings', []) as $group => $entries) {
            foreach ((array) $entries as $key => $meta) {
                $candidates->push([
                    'key' => (string) $key,
                    'label' => (string) ($meta['label'] ?? $key),
                    'group' => (string) $group,
                ]);
            }
        }

        return $this->candidates = $candidates;
    }

    /**
     * Rank a setting match: exact identifier/label, then prefix, then contains.
     */
    private function rank(array $setting, string $lower): ?int
    {
        $haystacks = [
            mb_strtolower($setting['key']),
            mb_strtolower($setting['label']),
        ];

        foreach ($haystacks as $haystack) {
            if ($haystack === $lower) {
                return 0;
            }
        }

        foreach ($haystacks as $haystack) {
            if (str_starts_with($haystack, $lower)) {
                return 1;
            }
        }

        foreach ($haystacks as $haystack) {
            if (str_contains($haystack, $lower)) {
                return 2;
            }
        }

        return null;
    }
}
