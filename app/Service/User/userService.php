<?php

declare(strict_types=1);

namespace Service\User;

use App\Models\User;

class UserService
{
    public function register($registerData): array
    {
        $input = $registerData->all();
        $input['password'] = bcrypt($input['password']);
        $input['password_confirmation'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['email'] = $user->email;

        return $success;

    }
}