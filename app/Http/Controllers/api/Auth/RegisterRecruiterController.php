<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRecruiterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\{Recruiter, User};

class RegisterRecruiterController extends Controller
{
    /**
     * Handle recruiter registration.
     */
    public function __invoke(RegisterRecruiterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($request->only(['username', 'dni', 'email', 'password']));

        $recruiter = Recruiter::create(
            $request->only(['company_id']) + ['user_id' => $user->id]
        );

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
