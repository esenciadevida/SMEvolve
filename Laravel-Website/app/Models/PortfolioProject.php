<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_category_id',
        'slug',
        'title',
        'status',
        'featured',
        'image',
        'industry',
        'project_type',
        'summary',
        'short_description',
        'sort_order',
        'is_published',
        'services',
        'services_slugs',
        'technologies',
        'gallery',
        'challenge',
        'solution',
        'features',
        'outcome',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'services' => 'array',
            'services_slugs' => 'array',
            'technologies' => 'array',
            'gallery' => 'array',
            'challenge' => 'array',
            'solution' => 'array',
            'features' => 'array',
            'outcome' => 'array',
            'meta' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }

    public function resolveCategorySlug(): ?string
    {
        return $this->category?->slug;
    }

    public function resolveCategoryName(): ?string
    {
        return $this->category?->name;
    }
}
