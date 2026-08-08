<?php

namespace App\Http\Requests\Public;

use App\Services\Search\PublicSearchService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublicSearchAutocompleteRequest extends FormRequest
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
        $types = array_keys(app(PublicSearchService::class)->availableResources());

        return [
            'q' => [
                'required',
                'string',
                'min:'.(int) config('website.search.min_query_length', 2),
                'max:'.(int) config('website.search.max_query_length', 120),
            ],
            'type' => ['nullable', Rule::in($types)],
            'limit' => ['nullable', 'integer', 'min:1', 'max:'.(int) config('website.search.max_results_per_resource', 10)],
        ];
    }
}
