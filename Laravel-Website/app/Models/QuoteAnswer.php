<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteAnswer extends Model
{
    protected $fillable = [
        'quote_session_id',
        'question_key',
        'question',
        'answer',
        'answer_type',
        'source',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
        ];
    }

    public function quoteSession(): BelongsTo
    {
        return $this->belongsTo(QuoteSession::class);
    }
}
