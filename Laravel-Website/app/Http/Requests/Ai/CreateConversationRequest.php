<?php

namespace App\Http\Requests\Ai;

use Illuminate\Foundation\Http\FormRequest;

class CreateConversationRequest extends FormRequest
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
            'session_id' => ['required', 'string', 'max:80', 'regex:/^[a-f0-9\-]{8,80}$/i'],
            'channel' => ['nullable', 'string', 'max:30', 'in:website,quote,admin,other'],
        ];
    }

    public function messages(): array
    {
        return [
            'session_id.regex' => 'Invalid client session identifier.',
        ];
    }
}
