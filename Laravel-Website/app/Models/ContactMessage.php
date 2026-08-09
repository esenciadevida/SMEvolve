<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'contact_method',
        'subject',
        'budget',
        'message',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function subjectLabel(): string
    {
        return (string) (config('company.form.subject_options.'.$this->subject) ?? $this->subject ?? 'General');
    }

    public function budgetLabel(): string
    {
        return (string) (config('company.form.budget_options.'.$this->budget) ?? $this->budget ?? 'Not supplied');
    }

    public function contactMethodLabel(): string
    {
        return (string) (config('company.form.contact_methods.'.$this->contact_method) ?? $this->contact_method ?? 'Not supplied');
    }

    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->forceFill(['is_read' => true, 'read_at' => now()])->save();
        }
    }
}
