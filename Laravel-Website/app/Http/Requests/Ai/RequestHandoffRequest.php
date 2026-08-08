<?php

namespace App\Http\Requests\Ai;

use App\Models\AiHandoff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestHandoffRequest extends FormRequest
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
            'reason' => ['required', 'string', 'max:40', Rule::in(AiHandoff::REASONS)],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
