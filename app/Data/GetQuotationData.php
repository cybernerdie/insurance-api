<?php
namespace App\Data;

use App\Enums\QuotationCurrencyEnum;
use App\Rules\AgeRule;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class GetQuotationData extends Data
{
    public function __construct(
        public string $age,
        public string $currency_id,
        public string $start_date,
        public string $end_date
    ) {}

    public static function rules(): array
    {
        return [
            'age'         => ['required', new AgeRule()],
            'currency_id' => ['required', Rule::in(QuotationCurrencyEnum::cases())],
            'start_date'  => ['required', 'date', 'date_format:Y-m-d'],
            'end_date'    => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }

    public function getAge(): array
    {
        return explode(',', $this->age);
    }

    public function getCurrency(): string
    {
        return $this->currency_id;
    }

    public function getStartDate(): string
    {
        return $this->start_date;
    }

    public function getEndDate(): string
    {
        return $this->end_date;
    }

    public function toArray(): array
    {
        return [
            'age'         => $this->getAge(),
            'currency_id' => $this->getCurrency(),
            'start_date'  => $this->getStartDate(),
            'end_date'    => $this->getEndDate(),
        ];
    }
}
