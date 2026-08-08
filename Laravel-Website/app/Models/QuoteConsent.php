<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteConsent extends Model
{
    protected $fillable = [
        'quote_session_id',
        'quote_submission_id',
        'consent_type',
        'document',
        'document_version',
        'accepted',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'accepted' => 'boolean',
            'accepted_at' => 'datetime',
        ];
    }

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }

    public function quoteSubmission(): BelongsTo
    {
        return $this->belongsTo(QuoteSubmission::class);
    }
}
