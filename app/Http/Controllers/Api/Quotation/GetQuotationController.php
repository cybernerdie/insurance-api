<?php

declare(strict_types=1);    

namespace App\Http\Controllers\Api\Quotation;

use App\Actions\Quotation\GetQuotationAction;
use App\DTOs\GetQuotationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\GetQuotationRequest;
use App\Http\Responses\ApiResponse;
use Exception;

class GetQuotationController extends Controller
{
    public function __invoke(GetQuotationRequest $request, GetQuotationAction $getQuotationAction)
    {
        $data = $request->validated();

        $quotationDTO = new GetQuotationDTO(
            age: data_get($data, 'age'),
            currency_id: data_get($data, 'currency_id'),
            start_date: data_get($data, 'start_date'),
            end_date: data_get($data, 'end_date'),
        );

        try {
            $quotation = $getQuotationAction->execute($quotationDTO);
            
            return ApiResponse::success(
                message: 'Quotation retrieved successfully.',
                data: $quotation
            );
        } catch (Exception $e) {
            report($e); 

            return ApiResponse::internalServerError(
                message: 'Failed to retrieve quotation. Please try again later.'
            );
        }
    }
}
