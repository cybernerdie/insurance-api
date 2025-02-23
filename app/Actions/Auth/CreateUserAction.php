<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Data\UserData;
use App\Models\User;

class CreateUserAction
{
    /**
     * Execute the action.
     * 
     * @return \App\Models\User
     */
    public function execute(UserData $userData): User
    {
        return User::create($userData->toArray());
    }
}
