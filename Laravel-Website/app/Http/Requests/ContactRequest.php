<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[+]?[0-9\s\-()]{7,25}$/'],
            'contact_method' => ['required', Rule::in(array_keys(config('company.form.contact_methods', [])))],
            'subject' => ['required', Rule::in(array_keys(config('company.form.subject_options', [])))],
            'budget' => ['nullable', Rule::in(array_keys(config('company.form.budget_options', [])))],
            'message' => ['required', 'string', 'min:30', 'max:2000'],
            'consent' => ['required', 'accepted'],
            'website' => ['prohibited'],
            'contact_token' => ['required', 'string'],
        ];
    }

    /**
     * Get friendly validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.max' => 'Your name must not exceed 120 characters.',
            'company.max' => 'Your business name must not exceed 120 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Your email address must not exceed 190 characters.',
            'phone.regex' => 'Please enter a valid phone number.',
            'contact_method.required' => 'Please select a preferred contact method.',
            'contact_method.in' => 'Please choose a valid contact method.',
            'subject.required' => 'Please select a subject.',
            'subject.in' => 'Please choose a valid subject.',
            'budget.in' => 'Please choose a valid budget range.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Please provide a few more details (at least 30 characters).',
            'message.max' => 'Your message must not exceed 2,000 characters.',
            'consent.required' => 'Please confirm you agree to the Privacy Policy.',
            'consent.accepted' => 'Please confirm you agree to the Privacy Policy.',
            'website.prohibited' => 'Your message could not be sent. Please try again.',
            'contact_token.required' => 'Your session has expired. Please refresh the page and try again.',
        ];
    }
}
