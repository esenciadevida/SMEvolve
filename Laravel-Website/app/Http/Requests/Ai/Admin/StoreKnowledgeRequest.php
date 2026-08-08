<?php

namespace App\Http\Requests\Ai\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKnowledgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:30', Rule::in(['service', 'package', 'faq', 'company', 'custom'])],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'max:20', Rule::in(['draft', 'published', 'archived'])],
            'priority' => ['nullable', 'string', 'max:20', Rule::in(['low', 'normal', 'high'])],
            'keywords_input' => ['nullable', 'string', 'max:500'],
        ];
    }
}
