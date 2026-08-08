<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAiUpdateRequest extends FormRequest
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
            'enabled' => ['nullable', 'boolean'],
            'model' => ['nullable', 'string', Rule::in(array_keys((array) config('ai.groq.approved_models', [])))],
            'max_output_tokens' => ['nullable', 'integer', 'min:128', 'max:4096'],
            'temperature' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ];
    }
}
