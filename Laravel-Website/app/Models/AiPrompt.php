<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiPrompt extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'active_version_id',
    ];

    public function versions(): HasMany
    {
        return $this->hasMany(AiPromptVersion::class, 'prompt_id');
    }

    public function activeVersion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AiPromptVersion::class, 'active_version_id');
    }
}
