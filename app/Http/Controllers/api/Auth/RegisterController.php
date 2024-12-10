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

        try {
            $result = $this->userRegisterService->registerUser($userData);

            return response()->json($result, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
