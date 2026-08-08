<?php

namespace App\Services\Search;

use App\Services\Content\ContentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FaqSearchProvider extends AbstractInMemorySearchProvider
{
    private const FIELDS = ['question', 'answer', 'category', 'tags'];

    public function __construct(
        private readonly ContentService $content,
    ) {
        parent::__construct('faqs', 'FAQs');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $faqs = collect($this->content->faqs())
            ->filter(fn (array $item) => ($item['status'] ?? 'active') === 'active')
            ->map(function (array $item) {
                $item['tags'] = implode(' ', $item['tags'] ?? []);

                return $item;
            });

        return $this->rank($faqs, $query, self::FIELDS, 'question');
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || empty($record['id'])) {
            return null;
        }

        return new SearchResult(
            type: 'faq',
            id: $record['id'],
            title: $record['question'],
            subtitle: Str::limit($record['answer'] ?? '', 160),
            url: route('faq', ['question' => $record['id']]),
            metadata: [
                'category' => $record['category'] ?? null,
            ],
        );
    }
}
