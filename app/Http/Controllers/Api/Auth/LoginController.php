<?php

declare(strict_types=1);    

namespace App\Http\Controllers\Api\Auth;

use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        /** @var User $user */
        $user = Auth::user();

        $tokenIdentifier = "{$user->ulid}-token";

        /** @var \Laravel\Passport\PersonalAccessTokenResult $token */
        $token = $user->createToken($tokenIdentifier);

        return ApiResponse::success(
            message: 'Login successful.',
            data: [
                'user' => UserResource::make($user)->resolve(),
                'token' => $token->accessToken,
            ]
        );
    }
}
