<?php

namespace App\Services\Quote;

use App\Models\QuoteRequirement;
use App\Models\QuoteSession;
use App\Models\QuoteSessionRequirement;
use Illuminate\Support\Collection;

class QuoteRequirementService
{
    /**
     * All active requirement catalog entries keyed by their stable key.
     *
     * @return Collection<string, QuoteRequirement>
     */
    public function catalog(): Collection
    {
        return QuoteRequirement::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key');
    }

    /**
     * Requirement options for a given project type from configuration.
     *
     * @return array<int, array<string, mixed>>
     */
    public function optionsForProjectType(string $projectType): array
    {
        return config("quote.features.{$projectType}", []);
    }

    /**
     * Confirm a requirement as a user selection for a session.
     */
    public function confirmRequirement(QuoteSession $session, string $key, string $source = QuoteSessionRequirement::SOURCE_USER): void
    {
        $requirement = $this->findActiveByKey($key);

        if ($requirement === null) {
            return;
        }

        $this->record($session, $requirement, [
            'source' => $source,
            'status' => QuoteSessionRequirement::STATUS_CONFIRMED,
        ]);
    }

    /**
     * Record an AI suggestion. AI suggestions are never automatically confirmed.
     */
    public function suggestRequirement(QuoteSession $session, string $key, ?string $notes = null): void
    {
        $requirement = $this->findActiveByKey($key);

        if ($requirement === null) {
            return;
        }

        $this->record($session, $requirement, [
            'source' => QuoteSessionRequirement::SOURCE_AI,
            'status' => QuoteSessionRequirement::STATUS_SUGGESTED,
            'notes' => $notes,
        ]);
    }

    /**
     * Mark a requirement as removed for a session.
     */
    public function removeRequirement(QuoteSession $session, string $key): void
    {
        $requirement = $this->findActiveByKey($key);

        if ($requirement === null) {
            return;
        }

        $this->record($session, $requirement, [
            'source' => QuoteSessionRequirement::SOURCE_USER,
            'status' => QuoteSessionRequirement::STATUS_REMOVED,
        ]);
    }

    /**
     * Confirm the set of selected feature keys for a session, removing entries
     * that are no longer selected.
     *
     * @param  array<int, string>  $keys
     */
    public function confirmMany(QuoteSession $session, array $keys): void
    {
        $keys = array_values(array_unique(array_filter($keys)));

        $confirmed = [];

        foreach ($keys as $key) {
            $this->confirmRequirement($session, $key);
            $confirmed[$key] = true;
        }

        $session->sessionRequirements()
            ->whereIn('status', [QuoteSessionRequirement::STATUS_CONFIRMED])
            ->whereHas('quoteRequirement', function ($query) use ($confirmed) {
                $query->whereNotIn('key', array_keys($confirmed));
            })
            ->delete();
    }

    /**
     * Requirements linked to a session, with source/status metadata.
     *
     * @return Collection<int, array{key: string, name: string, source: string, status: string}>
     */
    public function requirementsFor(QuoteSession $session): Collection
    {
        return $session->sessionRequirements()
            ->with('quoteRequirement')
            ->orderByDesc('id')
            ->get()
            ->map(fn (QuoteSessionRequirement $link) => [
                'key' => $link->quoteRequirement->key,
                'name' => $link->quoteRequirement->name,
                'source' => $link->source,
                'status' => $link->status,
            ]);
    }

    /**
     * Confirmed requirement keys for a session.
     *
     * @return array<int, string>
     */
    public function confirmedKeys(QuoteSession $session): array
    {
        return $session->sessionRequirements()
            ->whereIn('status', [QuoteSessionRequirement::STATUS_CONFIRMED, QuoteSessionRequirement::STATUS_SELECTED])
            ->whereHas('quoteRequirement', fn ($query) => $query->where('is_active', true))
            ->with('quoteRequirement')
            ->get()
            ->pluck('quoteRequirement.key')
            ->all();
    }

    private function findActiveByKey(string $key): ?QuoteRequirement
    {
        return QuoteRequirement::where('key', $key)
            ->where('is_active', true)
            ->first();
    }

    private function record(QuoteSession $session, QuoteRequirement $requirement, array $attributes): void
    {
        $session->sessionRequirements()->updateOrCreate(
            ['quote_requirement_id' => $requirement->id],
            $attributes
        );
    }
}
