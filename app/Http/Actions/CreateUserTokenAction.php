<?php

namespace App\Http\Actions;

use App\Models\User;
use Exception;

class CreateUserTokenAction
{
    public function handle(User $user)
    {
        try {
            return $user->createToken(time(), [])->plainTextToken;
        } catch (Exception $e) {
            return null;
        }
    }
}
