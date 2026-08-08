<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSearchAutocompleteRequest extends FormRequest
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
            'q' => ['required', 'string', 'min:' . (int) config('admin.search_min_query_length', 2), 'max:100'],
            'type' => ['nullable', Rule::in(['quotes', 'administrators', 'settings', 'knowledge', 'audit_logs'])],
            'limit' => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }
}
