<?php

namespace App\Services\Search;

use App\Models\QuoteSubmission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class QuoteSearchProvider extends AbstractSearchProvider
{
    private const COLUMNS = ['reference', 'contact_name', 'contact_email'];

    private const STATUS_LABELS = [
        QuoteSubmission::STATUS_SUBMITTED => 'New',
        QuoteSubmission::STATUS_UNDER_REVIEW => 'Reviewing',
        QuoteSubmission::STATUS_QUOTED => 'Quoted',
        QuoteSubmission::STATUS_COMPLETED => 'Completed',
        QuoteSubmission::STATUS_CANCELLED => 'Cancelled',
    ];

    public function __construct()
    {
        parent::__construct('quotes', 'Quotes', 'quotes.search');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        $lower = mb_strtolower($query);

        return $this->orderedQuery($lower)
            ->limit($limit)
            ->get();
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! $record instanceof QuoteSubmission) {
            return null;
        }

        return new SearchResult(
            type: 'quote',
            id: $record->id,
            title: $record->reference,
            subtitle: $record->contact_name,
            url: route('admin.quotes.show', $record),
            metadata: [
                'status' => self::STATUS_LABELS[$record->status] ?? ucfirst(str_replace('_', ' ', $record->status)),
                'status_key' => $record->status,
                'submitted_at' => optional($record->submitted_at)->toIso8601String(),
            ],
        );
    }

    private function orderedQuery(string $lower): Builder
    {
        return QuoteSubmission::query()
            ->tap(fn (Builder $builder) => $this->whereAnyMatch($builder, self::COLUMNS, $lower))
            ->orderByRaw(
                'CASE
                    WHEN LOWER(reference) = ? THEN 0
                    WHEN LOWER(contact_name) = ? THEN 1
                    WHEN LOWER(contact_email) = ? THEN 2
                    WHEN LOWER(reference) LIKE ? OR LOWER(contact_name) LIKE ? OR LOWER(contact_email) LIKE ? THEN 3
                    ELSE 4
                END',
                [$lower, $lower, $lower, $lower.'%', $lower.'%', $lower.'%']
            )
            ->orderByDesc('submitted_at');
    }
}
