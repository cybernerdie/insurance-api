<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Data\UserData;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\CreateUserAction;

class RegisterController extends Controller
{
    public function __invoke(UserData $userData, CreateUserAction $createUserAction): JsonResponse
    {
        /** @var User $user */
        $user = $createUserAction->execute(userData: $userData);

        Auth::login($user);

        $tokenIdentifier = "{$user->ulid}-token";

        /** @var \Laravel\Passport\PersonalAccessTokenResult $token */
        $token = $user->createToken($tokenIdentifier);

        return ApiResponse::success(
            message: 'Registration successful',
            data: [
                'user' => UserResource::make($user)->resolve(),
                'token' => $token->accessToken
            ]
        );
    }
}
