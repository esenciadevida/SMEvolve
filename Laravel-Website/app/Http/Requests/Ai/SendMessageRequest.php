<?php

namespace App\Http\Requests\Ai;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
            'message' => ['required', 'string', 'max:'.config('ai.limits.max_message_length')],
        ];
    }

    public function messages(): array
    {
        return [
            'session_id.regex' => 'Invalid client session identifier.',
        ];
    }
}
