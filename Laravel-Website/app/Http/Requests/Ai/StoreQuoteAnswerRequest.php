<?php

namespace App\Http\Requests\Ai;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteAnswerRequest extends FormRequest
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
            'question_key' => ['required', 'string', 'max:80'],
            'question' => ['nullable', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:2000'],
            'answer_type' => ['nullable', 'string', 'max:30', 'in:text,select,number,bool'],
        ];
    }
}
