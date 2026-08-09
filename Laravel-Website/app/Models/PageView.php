<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'page_views';

    protected $fillable = [
        'visitor_id',
        'path',
        'page_title',
        'referer_host',
        'browser',
        'os',
        'device_type',
        'locale',
        'is_mobile',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_mobile' => 'boolean',
            'viewed_at' => 'datetime',
        ];
    }
}
