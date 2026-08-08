<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class PortfolioCategoryUpdateRequest extends PortfolioCategoryStoreRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['slug'] = [
            'required',
            'string',
            'max:100',
            'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            Rule::unique('portfolio_categories', 'slug')->ignore($this->route('portfolio_category')),
        ];

        return $rules;
    }
}
