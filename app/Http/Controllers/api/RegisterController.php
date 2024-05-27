<?php
declare(strict_types=1);
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Service\User\RegisterMessage;
use Service\User\UserRegisterService;
use Exception;
use PDOException;

class RegisterController extends Controller
{
    use RegisterMessage;

    private UserRegisterService $userService;

    public function __construct(UserRegisterService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dataRegister = $request->only(['username', 'dni', 'email', 'specialization', 'password']);

        try {
            $result = $this->userService->createUser($dataRegister);

            if ($result !== false) {
                return $this->sendResponse($result, 'User registered successfully.');
            } else {
                return $this->sendError(['message' => 'ProcessFailed'], 'User register failed.');
            }

        } catch (PDOException $e) {
            Log::error('Database error during user registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->sendError('Database error occurred during registration.', 500);

        } catch (Exception $e) {
            Log::error('Error during user registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->sendError('An error occurred during registration. Please try again later.');
        }
    }
}
