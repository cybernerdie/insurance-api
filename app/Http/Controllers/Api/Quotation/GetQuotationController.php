<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Quotation;

use App\Actions\Quotation\GetQuotationAction;
use App\Data\GetQuotationData;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class GetQuotationController extends Controller
{
    public function __invoke(GetQuotationData $quotationData, GetQuotationAction $getQuotationAction): JsonResponse
    {
        $quotation = $getQuotationAction->execute(quotationData: $quotationData);

        return ApiResponse::success(
            message: 'Quotation retrieved successfully.',
            data: $quotation
        );
    }
}
