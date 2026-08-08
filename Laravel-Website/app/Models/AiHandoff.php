<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AiHandoff extends Model
{
    public const STATUS_REQUESTED = 'requested';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CANCELLED = 'cancelled';

    public const REASONS = [
        'user_requested',
        'complex_request',
        'pricing_negotiation',
        'complaint',
        'unknown_information',
        'technical_issue',
    ];

    protected $fillable = [
        'uuid',
        'conversation_id',
        'quote_session_id',
        'reason',
        'status',
        'requested_at',
        'resolved_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'requested_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (AiHandoff $handoff) {
            if (empty($handoff->uuid)) {
                $handoff->uuid = (string) Str::uuid();
            }
        });
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }
}
