<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'title',
        'description',
        'icon',
        'data',
        'sort_order',
        'is_published',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * List of content types recognised by the admin content manager.
     *
     * @return array<int, string>
     */
    public static function types(): array
    {
        return array_keys(config('content.types', []));
    }
}
