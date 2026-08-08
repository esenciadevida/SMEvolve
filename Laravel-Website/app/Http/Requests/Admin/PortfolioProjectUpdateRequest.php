<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class PortfolioProjectUpdateRequest extends PortfolioProjectStoreRequest
{
    /**
     * @return array<string, mixed>
     */
    protected function projectRules(): array
    {
        $rules = parent::projectRules();

        $rules['slug'] = [
            'required',
            'string',
            'max:150',
            'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            Rule::unique('portfolio_projects', 'slug')->ignore($this->route('portfolio_project')),
        ];

        return $rules;
    }
}
