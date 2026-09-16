<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioProjectStoreRequest extends FormRequest
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
        return $this->projectRules();
    }

    /**
     * @return array<string, mixed>
     */
    protected function projectRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('portfolio_projects', 'slug')],
            'portfolio_category_id' => ['nullable', 'integer', Rule::exists('portfolio_categories', 'id')],
            'status' => ['required', 'string', 'max:60'],
            'featured' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'url', 'max:500'],
            'image_upload' => ['nullable', 'file', 'image', 'max:5120'],
            'industry' => ['nullable', 'string', 'max:100'],
            'project_type' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'short_description' => ['required', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'technologies' => ['nullable', 'string', 'max:1000'],
            'services_slugs' => ['nullable', 'array'],
            'services_slugs.*' => ['string', 'max:100'],
            'gallery' => ['nullable', 'array'],
            'gallery.*.label' => ['nullable', 'string', 'max:120'],
            'gallery.*.type' => ['nullable', 'string', 'max:200'],
            'gallery.*.image' => ['nullable', 'url', 'max:500'],
            'gallery.*.image_upload' => ['nullable', 'file', 'image', 'max:5120'],
            'challenge' => ['nullable', 'array'],
            'challenge.heading' => ['nullable', 'string', 'max:200'],
            'challenge.description' => ['nullable', 'string', 'max:2000'],
            'challenge.points' => ['nullable', 'string', 'max:4000'],
            'solution' => ['nullable', 'array'],
            'solution.heading' => ['nullable', 'string', 'max:200'],
            'solution.description' => ['nullable', 'string', 'max:2000'],
            'solution.points' => ['nullable', 'string', 'max:4000'],
            'features' => ['nullable', 'array'],
            'features.*.icon' => ['nullable', 'string', 'max:60'],
            'features.*.title' => ['nullable', 'string', 'max:120'],
            'features.*.description' => ['nullable', 'string', 'max:500'],
            'outcome' => ['nullable', 'array'],
            'outcome.heading' => ['nullable', 'string', 'max:200'],
            'outcome.description' => ['nullable', 'string', 'max:2000'],
            'outcome.points' => ['nullable', 'string', 'max:4000'],
            'meta' => ['nullable', 'array'],
            'meta.title' => ['nullable', 'string', 'max:200'],
            'meta.description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
