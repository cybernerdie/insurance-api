<?php

declare(strict_types=1);

namespace App\Actions\Quotation;

use App\DTOs\GetQuotationDTO;
use App\Enums\AgeLoadEnum;
use Illuminate\Support\Carbon;

class GetQuotationAction
{
    private const FIXED_RATE = 3; 

    public function execute(GetQuotationDTO $quotationDTO): array
    {
        $this->validateAge($quotationDTO->getAge());

        $tripLength = $this->calculateTripLength(
            $quotationDTO->getStartDate(),
            $quotationDTO->getEndDate()
        );

        $total = $this->calculateTotal($quotationDTO, $tripLength);

        return [
            'total' => number_format($total, 2), 
            'currency_id' => $quotationDTO->getCurrency(),
            'quotation_id' => 1,
        ];
    }

    private function validateAge(array $ages): void
    {
        collect($ages)->each(function ($age) {
            if (!is_numeric($age) || (int)$age < 18 || (int)$age > 70) {
                throw new \InvalidArgumentException('Each age must be between 18 and 70.');
            }
        });
    }

    private function calculateTripLength(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($start->greaterThan($end)) {
            throw new \InvalidArgumentException("Start date must be before the end date.");
        }

        $tripLength = (int) $start->diffInDays($end) + 1;

        if ($tripLength < 1) {
            throw new \InvalidArgumentException('End date must be after start date.');
        }

        return $tripLength;
    }

    private function calculateTotal(GetQuotationDTO $quotationDTO, int $tripLength): float
    {
        $total = 0;

        collect($quotationDTO->getAge())->each(function ($age) use (&$total, $tripLength) {
            $ageLoad = (float) AgeLoadEnum::fromAge((int)$age)->value;
            $total += self::FIXED_RATE * $ageLoad * $tripLength;
        });

        return $total;
    }
}
