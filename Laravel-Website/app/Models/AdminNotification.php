<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotification extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'administrator_id',
        'event',
        'channel',
        'subject',
        'body',
        'status',
        'sent_at',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
