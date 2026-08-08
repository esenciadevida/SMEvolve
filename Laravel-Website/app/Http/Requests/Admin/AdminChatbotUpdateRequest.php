<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminChatbotUpdateRequest extends FormRequest
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
            'welcome_message' => ['nullable', 'string', 'max:1000'],
            'availability_message' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
