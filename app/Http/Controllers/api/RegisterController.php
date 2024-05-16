<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use PDOException;
use Service\User\registerMessage;
use Service\User\UserRegisterService;

/* TODO:
    1: porque existe el metodo boot() en la clase User, porque se esta validando alli el password? no deria validarse esto en controlador con un formrequest?
*/

class RegisterController extends Controller
{

    use registerMessage;

    private UserRegisterService $userService;

    public function __construct(UserRegisterService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->createUser($request);
            
            //if(empty($result['token']) == False && empty($result['token']) == False){
             if($result != False){
				return $this->sendResponse($result, 'User registered successfully.');
			}else{
				return $this->sendError(['message'=>'ProcessFailed'], 'User register failed.', 401);
			}
            
        } catch (Exception $exception) {
            // Log the exception for debugging and potential alerting
            Log::error('Error during user registration:', [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            // Handle specific exceptions if necessary (e.g., PDOException for database errors)
            if ($exception instanceof PDOException) {
                return $this->sendError('Database error occurred during registration.', 500);
            }

            // Handle generic exception
            return $this->sendError('An error occurred during registration. Please try again later.');
        }
    }
}
