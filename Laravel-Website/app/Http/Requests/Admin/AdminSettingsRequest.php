<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingsRequest extends FormRequest
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
        $group = (string) $this->route('group');
        $definitions = config("admin.settings.{$group}", []);

        $rules = [];

        foreach ($definitions as $key => $definition) {
            $rules[$key] = $definition['rules'] ?? ['nullable'];
        }

        return $rules;
    }

    /**
     * @return array<int, string>
     */
    public function messages(): array
    {
        $group = (string) $this->route('group');
        $definitions = config("admin.settings.{$group}", []);
        $messages = [];

        foreach ($definitions as $key => $definition) {
            $label = $definition['label'] ?? $key;
            $messages["{$key}.required"] = "The {$label} field is required.";
            $messages["{$key}.email"] = "The {$label} must be a valid email address.";
            $messages["{$key}.url"] = "The {$label} must be a valid URL.";
        }

        return $messages;
    }
}
