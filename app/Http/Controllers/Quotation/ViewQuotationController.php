<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewQuotationController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('quotation.index');
    }
}
