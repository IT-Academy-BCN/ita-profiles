<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRecruiterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\{Recruiter, User};
use Illuminate\Support\Facades\Hash;

class RegisterRecruiterController extends Controller
{
    /**
     * Handle recruiter registration.
     */
    public function __invoke(RegisterRecruiterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create(array_intersect_key($data, array_flip(['username', 'dni', 'email', 'password'])));

        $recruiter = Recruiter::create(array_intersect_key($data, array_flip(['company_id'])) + [
            'user_id' => $user->id,
        ]);

        $token = $user->createToken('RecruiterAccessToken')->accessToken;

        return response()->json([
            'message' => 'Recruiter registered successfully.',
            'data' => [
                'user' => $user,
                'recruiter' => $recruiter,
                'token' => $token,
            ],
        ], 201);
    }
}
