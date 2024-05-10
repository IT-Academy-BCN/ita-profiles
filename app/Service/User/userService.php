<?php

declare(strict_types=1);

namespace Service\User;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserService
{

    public function createUser(RegisterRequest $registerData): array
    {
        $input = $registerData->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('ITAcademy')->accessToken;
        $success['email'] = $user->email;

        return $success;

    }
    
}
