<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuoteSubmission extends Model
{
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_QUOTED = 'quoted';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'quote_session_id',
        'reference',
        'status',
        'contact_name',
        'contact_email',
        'contact_phone',
        'preferred_contact_method',
        'snapshot',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'snapshot' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }

    public function consents(): HasMany
    {
        return $this->hasMany(QuoteConsent::class);
    }
}
