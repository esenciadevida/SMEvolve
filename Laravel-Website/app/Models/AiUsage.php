<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiUsage extends Model
{
    protected $table = 'ai_usage';

    protected $fillable = [
        'request_id',
        'conversation_id',
        'message_id',
        'endpoint',
        'provider',
        'model',
        'input_tokens',
        'output_tokens',
        'total_tokens',
        'response_time_ms',
        'status',
        'error_type',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
