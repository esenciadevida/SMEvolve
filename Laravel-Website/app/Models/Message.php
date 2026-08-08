<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Message extends Model
{
    public const ROLE_USER = 'user';

    public const ROLE_ASSISTANT = 'assistant';

    public const ROLE_SYSTEM = 'system';

    protected $fillable = [
        'uuid',
        'conversation_id',
        'role',
        'content',
        'provider',
        'model',
        'token_input',
        'token_output',
        'response_time_ms',
        'status',
        'request_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Message $message) {
            if (empty($message->uuid)) {
                $message->uuid = (string) Str::uuid();
            }
        });
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
