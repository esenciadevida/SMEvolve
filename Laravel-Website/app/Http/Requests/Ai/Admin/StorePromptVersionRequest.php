<?php

namespace App\Http\Requests\Ai\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePromptVersionRequest extends FormRequest
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
            'version' => ['required', 'string', 'max:20'],
            'content' => ['required', 'string'],
            'activate' => ['nullable', 'boolean'],
        ];
    }
}
