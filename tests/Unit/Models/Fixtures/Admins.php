<?php

declare(strict_types=1);

namespace Models\Fixtures;

use App\Models\Admin;

class Admins
{
    public static function anAdmin(): Admin
    {
        return new Admin([
            'user_id' => 1,
            'name' => 'a-name',
            'surname' => 'a-surname',
            'dni' => '00000000Z',
            'email' => 'an.example@email.com',
            'password' => 'a-password',
        ]);
    }
}
