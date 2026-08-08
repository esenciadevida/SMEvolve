<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteSessionRequirement extends Model
{
    public const SOURCE_USER = 'user';
    public const SOURCE_AI = 'ai';
    public const SOURCE_SYSTEM = 'system';

    public const STATUS_SUGGESTED = 'suggested';
    public const STATUS_SELECTED = 'selected';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_REMOVED = 'removed';

    protected $fillable = [
        'quote_session_id',
        'quote_requirement_id',
        'source',
        'status',
        'notes',
    ];

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }

    public function quoteRequirement(): BelongsTo
    {
        return $this->belongsTo(QuoteRequirement::class);
    }
}
