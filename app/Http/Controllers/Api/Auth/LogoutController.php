<?php

declare(strict_types=1);    

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->token()->revoke();

        return ApiResponse::success(message: 'Logout successful.');
    }
}
