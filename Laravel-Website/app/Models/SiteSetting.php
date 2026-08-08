<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'string',
        ];
    }
}
