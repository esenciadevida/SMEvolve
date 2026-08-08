<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KnowledgeItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'type',
        'title',
        'slug',
        'content',
        'status',
        'priority',
        'metadata',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (KnowledgeItem $item) {
            if (empty($item->uuid)) {
                $item->uuid = (string) Str::uuid();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
