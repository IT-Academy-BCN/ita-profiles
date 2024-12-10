<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Resume,
    Student,
    User,
};
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();

        try {
            $result = DB::transaction(function () use ($userData) {
                // Crear usuario
                $userData['password'] = bcrypt($userData['password']);
                $user = User::create($userData);

                // Crear estudiante relacionado
                $student = Student::create(['user_id' => $user->id]);

                // Crear currículum relacionado
                Resume::create([
                    'student_id' => $student->id,
                    'specialization' => $userData['specialization'] ?? null,
                ]);

                // Generar token de acceso
                return [
                    'token' => $user->createToken('ITAcademy')->accessToken,
                    'email' => $user->email,
                ];
            });

            return response()->json($result, 201);
        } catch (\Exception $e) {
            Log::error('Error during user registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
