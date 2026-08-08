<?php

namespace App\Services\Admin;

use App\Models\QuoteSubmission;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminQuoteService
{
    /**
     * @param  array{query?: ?string, status?: ?string, from?: ?string, to?: ?string, sort?: ?string, per_page?: int}  $filters
     */
    public function search(array $filters = []): LengthAwarePaginator
    {
        $sort = $filters['sort'] ?? 'newest';
        $perPage = $filters['per_page'] ?? 25;

        $query = QuoteSubmission::query();

        if (filled($filters['query'] ?? null)) {
            $term = (string) $filters['query'];
            $query->where(function ($q) use ($term) {
                $q->where('reference', 'like', "%{$term}%")
                    ->orWhere('contact_name', 'like', "%{$term}%")
                    ->orWhere('contact_email', 'like', "%{$term}%");
            });
        }

        if (filled($filters['status'] ?? null)) {
            $query->where('status', $filters['status']);
        }

        if (filled($filters['from'] ?? null)) {
            $query->whereDate('submitted_at', '>=', $filters['from']);
        }

        if (filled($filters['to'] ?? null)) {
            $query->whereDate('submitted_at', '<=', $filters['to']);
        }

        $query->with('quoteSession:id,uuid,project_type,business_name');

        match ($sort) {
            'oldest' => $query->orderBy('submitted_at'),
            'status' => $query->orderBy('status')->orderByDesc('id'),
            default => $query->orderByDesc('id'),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    public function updateStatus(QuoteSubmission $quote, string $status): QuoteSubmission
    {
        $quote->update(['status' => $status]);

        return $quote;
    }

    /**
     * @return array<string, string>
     */
    public function statusOptions(): array
    {
        return [
            QuoteSubmission::STATUS_SUBMITTED => 'New',
            QuoteSubmission::STATUS_UNDER_REVIEW => 'Reviewing',
            QuoteSubmission::STATUS_QUOTED => 'Quoted',
            QuoteSubmission::STATUS_COMPLETED => 'Completed',
            QuoteSubmission::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function statusLabel(string $status): string
    {
        return $this->statusOptions()[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}
