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
        'ip_address',
        'user_agent',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
