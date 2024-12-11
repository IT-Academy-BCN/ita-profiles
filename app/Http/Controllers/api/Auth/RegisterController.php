<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\{
    Resume,
    Student,
    User,
};

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();

        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);

        $student = Student::create(['user_id' => $user->id]);

        Resume::create([
            'student_id' => $student->id,
            'specialization' => $userData['specialization'] ?? null,
        ]);

        $result = [
            'token' => $user->createToken('ITAcademy')->accessToken,
            'email' => $user->email,
        ];

        return response()->json($result, 201);
    }
}
