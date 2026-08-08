<?php

namespace App\Http\Requests\Admin;

use App\Models\QuoteSubmission;
use Illuminate\Foundation\Http\FormRequest;

class AdminQuoteStatusRequest extends FormRequest
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
            'status' => ['required', 'string', 'in:'.implode(',', $this->statuses())],
        ];
    }

    /**
     * @return array<int, string>
     */
    private function statuses(): array
    {
        return [
            QuoteSubmission::STATUS_SUBMITTED,
            QuoteSubmission::STATUS_UNDER_REVIEW,
            QuoteSubmission::STATUS_QUOTED,
            QuoteSubmission::STATUS_COMPLETED,
            QuoteSubmission::STATUS_CANCELLED,
        ];
    }
}
