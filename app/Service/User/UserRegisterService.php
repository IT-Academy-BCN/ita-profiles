<?php

declare(strict_types=1);

namespace App\Service\User;

use Illuminate\Support\Facades\DB;
use App\Models\{
    Resume,
    Student,
    User,
};
use App\Exceptions\{
    UserRegisterException,
    ResumeCreateException,
    TokenGenerateException,
};
use Exception;
use PDOException;
use Error;

class UserRegisterService
{
    public function registerUser(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            $student = Student::create(['user_id' => $user->id]);

            Resume::create([
                'student_id' => $student->id,
                'specialization' => $data['specialization'] ?? null,
            ]);

            return [
                'token' => $user->createToken('ITAcademy')->accessToken,
                'email' => $user->email,
            ];
        });
    }
}
