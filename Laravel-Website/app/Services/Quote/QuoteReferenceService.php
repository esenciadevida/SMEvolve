<?php

namespace App\Services\Quote;

use App\Models\QuoteSubmission;

class QuoteReferenceService
{
    /**
     * Generate a unique, human-readable public reference such as SME-2026-001245.
     */
    public function generate(?\DateTimeInterface $date = null): string
    {
        $date = $date ?? now();

        $prefix = (string) config('quote.references.prefix', 'SME-');

        do {
            $reference = $prefix.$date->format('Y').'-'.str_pad((string) mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (QuoteSubmission::where('reference', $reference)->exists());

        return $reference;
    }
}
