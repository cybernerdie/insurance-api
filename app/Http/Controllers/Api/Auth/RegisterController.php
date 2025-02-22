<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\RegisterUserDTO;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\CreateUserAction;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, CreateUserAction $createUserAction)
    {
        try {
            $userData = new RegisterUserDTO(
                email: $request->email,
                password: $request->password,
                name: $request->name
            );

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
        } catch (\Exception $e) {
            report($e);
            
            return ApiResponse::internalServerError(
                message: 'Registration failed, please try again',
            );
        }
    }
}
