<?php
declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Service\User\UserRegisterService;
use Exception;
use PDOException;

class RegisterController extends Controller
{

    private UserRegisterService $userService;

    public function __construct(UserRegisterService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dataRegister = $request->only(['username', 'dni', 'email', 'specialization', 'password']);

        DB::beginTransaction();

        try {
            $result = $this->userService->createUser($dataRegister);

            if ($result !== false) {
                DB::commit();
                return response()->json([
                    'message'=> 'User registered successfully.',
                    'email'=> $result['email'],
                    'token'=> $result['token']
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'message'=> 'ProcessFailed. User register Failed', 400
                ]);
            }
        } catch (PDOException $e) {
            DB::rollBack();
            Log::error('Database error during user registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('Database error occurred during registration.', 500);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error during user registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('An error occurred during registration. Please try again later.', 500);
        }
    }
}
