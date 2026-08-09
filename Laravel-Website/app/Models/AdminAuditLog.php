<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAuditLog extends Model
{
    protected $fillable = [
        'administrator_id',
        'action',
        'resource_type',
        'resource_id',
        'old_value',
        'new_value',
        'status',
        'description',
        'request_id',
        'ip_address',
        'user_agent',
        'browser',
        'os',
        'device_type',
        'location',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
