<?php

declare(strict_types=1);

use App\Actions\Quotation\GetQuotationAction;
use App\DTOs\GetQuotationDTO;

it('calculates the correct quotation total', function () {
    $dto = new GetQuotationDTO(
        age : "28,35",
        currency_id : "USD",
        start_date : "2020-10-01",
        end_date : "2020-10-30"
    );

    $result = resolve(GetQuotationAction::class)->execute($dto);

    expect($result)->toMatchArray([
        'total' => '117.00',
        'currency_id' => $dto->getCurrency(),
        'quotation_id' => 1,
    ]);
});

it('throws an exception for invalid age', function () {
    $dto = new GetQuotationDTO(
        age : "17",
        currency_id : "USD",
        start_date : "2020-10-01",
        end_date : "2020-10-30"
    );

    $action = new GetQuotationAction();
    $action->execute($dto);
})->throws(InvalidArgumentException::class, 'Each age must be between 18 and 70.');

it('throws an exception for an invalid date range', function () {
    $dto = new GetQuotationDTO(
        age : "28,35",
        currency_id : "USD",
        start_date : "2020-10-30",
        end_date : "2020-10-01"
    );

    $action = new GetQuotationAction();
    $action->execute($dto);
})->throws(InvalidArgumentException::class, 'Start date must be before the end date.');