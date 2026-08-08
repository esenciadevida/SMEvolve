<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QuoteSession extends Model
{
    use SoftDeletes;

    public const STATUS_STARTED = 'started';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_REVIEW = 'review';

    public const STATUS_ABANDONED = 'abandoned';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_SUBMITTED = 'submitted';

    protected $fillable = [
        'uuid',
        'conversation_id',
        'session_id',
        'status',
        'current_step',
        'project_type',
        'business_name',
        'industry',
        'description',
        'budget_range',
        'timeline',
        'recommended_service',
        'recommended_package',
        'complexity',
        'lead_score',
        'ai_summary',
        'contact_name',
        'contact_email',
        'contact_phone',
        'preferred_contact_method',
        'started_at',
        'last_activity_at',
        'completed_at',
        'expires_at',
        'submitted_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'started_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'completed_at' => 'datetime',
            'expires_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (QuoteSession $session) {
            if (empty($session->uuid)) {
                $session->uuid = (string) Str::uuid();
            }
        });
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuoteAnswer::class);
    }

    public function requirements(): BelongsToMany
    {
        return $this->belongsToMany(QuoteRequirement::class, 'quote_session_requirements')
            ->withPivot('source', 'status', 'notes')
            ->withTimestamps();
    }

    public function sessionRequirements(): HasMany
    {
        return $this->hasMany(QuoteSessionRequirement::class);
    }

    public function aiInteractions(): HasMany
    {
        return $this->hasMany(QuoteAIInteraction::class);
    }

    public function submission(): HasOne
    {
        return $this->hasOne(QuoteSubmission::class);
    }

    public function consents(): HasMany
    {
        return $this->hasMany(QuoteConsent::class);
    }

    public function isOwnedBy(string $sessionId): bool
    {
        return hash_equals((string) $this->session_id, (string) $sessionId);
    }

    public function isSubmittable(): bool
    {
        return ! in_array($this->status, [static::STATUS_SUBMITTED], true);
    }

    public function isExpired(): bool
    {
        return $this->status === static::STATUS_EXPIRED
            || ($this->expires_at !== null && $this->expires_at->isPast());
    }

    public function touchActivity(): void
    {
        $this->forceFill([
            'last_activity_at' => now(),
            'expires_at' => now()->addMinutes((int) config('quote.session.expires_after_minutes', 4320)),
        ])->save();
    }

    public function markReview(): void
    {
        $this->forceFill([
            'status' => static::STATUS_REVIEW,
            'last_activity_at' => now(),
        ])->save();
    }

    public function markSubmitted(): void
    {
        $this->forceFill([
            'status' => static::STATUS_SUBMITTED,
            'submitted_at' => now(),
            'last_activity_at' => now(),
            'completed_at' => now(),
        ])->save();
    }

    public function markAbandoned(): void
    {
        $this->forceFill([
            'status' => static::STATUS_ABANDONED,
            'last_activity_at' => now(),
        ])->save();
    }

    public function markExpired(): void
    {
        $this->forceFill([
            'status' => static::STATUS_EXPIRED,
        ])->save();
    }
}
