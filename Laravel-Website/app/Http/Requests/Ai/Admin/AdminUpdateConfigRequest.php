<?php

namespace App\Http\Requests\Ai\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateConfigRequest extends FormRequest
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
            'values' => ['required', 'array'],
            'values.*' => ['nullable'],
        ];
    }
}
