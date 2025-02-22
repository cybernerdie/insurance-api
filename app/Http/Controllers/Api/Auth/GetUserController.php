<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class GetUserController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return ApiResponse::success(
            message: 'User data retrieved successfully.',
            data: [
                'user' => UserResource::make($user)->resolve(),
            ]
        );
    }
}
