<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiAuditLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'resource_type',
        'resource_id',
        'old_value',
        'new_value',
        'ip_address',
        'user_agent',
    ];
}
