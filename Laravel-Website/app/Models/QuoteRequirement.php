<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteRequirement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key',
        'name',
        'description',
        'category',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function quoteSessions(): BelongsToMany
    {
        return $this->belongsToMany(QuoteSession::class, 'quote_session_requirements')
            ->withPivot('source', 'status', 'notes')
            ->withTimestamps();
    }
}
