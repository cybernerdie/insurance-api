<?php

declare(strict_types=1);

namespace App\Actions\Quotation;

use App\Data\GetQuotationData;
use App\Enums\AgeLoadEnum;
use Illuminate\Support\Carbon;

class GetQuotationAction
{
    private const FIXED_RATE = 3; 

    public function execute(GetQuotationData $quotationData): array
    {
        $tripLength = $this->calculateTripLength(
            $quotationData->getStartDate(),
            $quotationData->getEndDate()
        );

        $total = $this->calculateTotal($quotationData, $tripLength);

        return [
            'total' => number_format($total, 2), 
            'currency_id' => $quotationData->getCurrency(),
            'quotation_id' => rand(1, 1000),
        ];
    }

    private function calculateTripLength(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($start->greaterThan($end)) {
            throw new \InvalidArgumentException('Start date must be before end date.');
        }
        
        $tripLength = (int) $start->diffInDays($end) + 1;

        if ($tripLength < 1) {
            throw new \InvalidArgumentException('End date must be after start date.');
        }

        return $tripLength;
    }

    private function calculateTotal(GetQuotationData $quotationData, int $tripLength): float
    {
        $total = 0;

        collect($quotationData->getAge())->each(function ($age) use (&$total, $tripLength) {
            $ageLoad = (float) AgeLoadEnum::fromAge((int)$age)->value;
            $total += self::FIXED_RATE * $ageLoad * $tripLength;
        });

        return $total;
    }
}
