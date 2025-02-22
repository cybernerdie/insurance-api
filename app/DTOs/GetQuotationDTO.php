<?php

namespace App\DTOs;

class GetQuotationDTO
{
    public function __construct(
        public string $age,
        public string $currency_id,
        public string $start_date,
        public string $end_date
    ) {}

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
            'age' => $this->getAge(),
            'currency_id' => $this->getCurrency(),
            'start_date' => $this->getStartDate(),
            'end_date' => $this->getEndDate(),
        ];
    }
}
