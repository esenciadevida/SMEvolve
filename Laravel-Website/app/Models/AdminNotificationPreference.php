<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotificationPreference extends Model
{
    protected $fillable = [
        'administrator_id',
        'event',
        'channel',
        'enabled',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
