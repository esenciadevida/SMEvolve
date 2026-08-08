<?php

namespace App\Http\Requests\Public;

use App\Services\Search\PublicSearchService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublicSearchRequest extends FormRequest
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
            'q' => ['nullable', 'string', 'max:' . (int) config('website.search.max_query_length', 120)],
            'type' => ['nullable', Rule::in($types)],
        ];
    }
}
