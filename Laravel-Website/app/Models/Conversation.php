<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use SoftDeletes;

    public const STATUS_NEW = 'new';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_IDLE = 'idle';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_ABANDONED = 'abandoned';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'uuid',
        'session_id',
        'status',
        'channel',
        'visitor_id',
        'started_at',
        'last_message_at',
        'completed_at',
        'expires_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'started_at' => 'datetime',
            'last_message_at' => 'datetime',
            'completed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Conversation $conversation) {
            if (empty($conversation->uuid)) {
                $conversation->uuid = (string) Str::uuid();
            }
        });
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function quoteSessions(): HasMany
    {
        return $this->hasMany(QuoteSession::class);
    }

    public function handoffs(): HasMany
    {
        return $this->hasMany(AiHandoff::class);
    }

    public function isOwnedBy(string $sessionId): bool
    {
        return hash_equals((string) $this->session_id, (string) $sessionId);
    }

    public function isAccessible(): bool
    {
        if ($this->status === static::STATUS_COMPLETED || $this->status === static::STATUS_ARCHIVED) {
            return false;
        }

        return $this->expires_at === null || $this->expires_at->isFuture();
    }
}
