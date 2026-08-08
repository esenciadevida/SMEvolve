<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConfiguration extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'is_public',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }
}
