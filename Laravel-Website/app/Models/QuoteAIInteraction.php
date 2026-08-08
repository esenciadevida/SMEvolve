<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteAIInteraction extends Model
{
    protected $table = 'quote_ai_interactions';

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_TIMEOUT = 'timeout';
    public const STATUS_RATE_LIMITED = 'rate_limited';

    protected $fillable = [
        'quote_session_id',
        'operation',
        'provider',
        'model',
        'prompt_version',
        'status',
        'input_hash',
        'input_tokens',
        'output_tokens',
        'duration_ms',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'input_tokens' => 'integer',
            'output_tokens' => 'integer',
            'duration_ms' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }
}
