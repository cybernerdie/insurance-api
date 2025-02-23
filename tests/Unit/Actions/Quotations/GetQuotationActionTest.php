<?php

declare(strict_types=1);

use App\Data\GetQuotationData;
use App\Actions\Quotation\GetQuotationAction;

it('calculates the correct quotation total', function () {
    $quotationData = new GetQuotationData(
        age : "28,35",
        currency_id : "USD",
        start_date : "2020-10-01",
        end_date : "2020-10-30"
    );

    $result = resolve(GetQuotationAction::class)->execute($quotationData);

    expect($result)->toMatchArray([
        'total' => '117.00',
        'currency_id' => $quotationData->getCurrency(),
    ]);
});

it('throws an exception for invalid age', function () {
    $this->expectException(InvalidArgumentException::class);

    $quotationData = new GetQuotationData(
        age: "17",
        currency_id: "USD",
        start_date: "2020-10-01",
        end_date: "2020-10-30"
    );

    $action = new GetQuotationAction();
    $action->execute($quotationData);
});

it('throws an exception for an invalid date range', function () {
    $this->expectException(InvalidArgumentException::class);

    $quotationData = new GetQuotationData(
        age : "28,35",
        currency_id : "USD",
        start_date : "2020-10-30",
        end_date : "2020-10-01"
    );

    $action = new GetQuotationAction();
    $action->execute($quotationData);
});