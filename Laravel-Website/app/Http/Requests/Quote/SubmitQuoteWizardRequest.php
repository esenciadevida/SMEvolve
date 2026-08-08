<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuoteWizardRequest extends FormRequest
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
            'preferred_contact_method' => ['nullable', 'string', 'max:30', 'in:email,phone,whatsapp,any'],
        ];
    }
}
