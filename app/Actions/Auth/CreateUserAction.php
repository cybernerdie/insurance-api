<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DTOs\RegisterUserDTO;
use App\Models\User;

class CreateUserAction
{
    /**
     * Execute the action.
     * 
     * @return \App\Models\User
     */
    public function execute(RegisterUserDTO $userData): User
    {
        return User::create($userData->toArray());
    }
}
