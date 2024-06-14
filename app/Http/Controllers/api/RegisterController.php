<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Service\User\UserRegisterService;
use Exception;

class RegisterController extends Controller
{

    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->only(['username', 'dni', 'email', 'specialization', 'password']);

        DB::beginTransaction();

        try {
            $result = $this->userRegisterService->createUser($input);

            DB::commit();

            return response()->json($result, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
