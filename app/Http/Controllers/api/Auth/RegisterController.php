<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Service\User\UserRegisterService;
use Illuminate\Support\Facades\{
    DB,
    Log,
};

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
        } catch (\DomainException $e) {
            DB::rollBack();
            Log::error('Domain exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(null, $e->getCode()); // We want the error is only shown in log report
        }
    }
}
