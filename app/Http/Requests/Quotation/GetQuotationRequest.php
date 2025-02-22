<?php

namespace App\Http\Requests\Quotation;

use App\Rules\AgeRule;
use Illuminate\Validation\Rule;
use App\Enums\QuotationCurrencyEnum;
use Illuminate\Foundation\Http\FormRequest;

class GetQuotationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age' => ['required', new AgeRule()],
            'currency_id' => ['required', Rule::in(QuotationCurrencyEnum::cases())],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }
}
