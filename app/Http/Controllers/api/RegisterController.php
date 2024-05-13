<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\registerRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PDOException;
use Service\User\registerMessage;
use Service\User\UserService;

/* TODO:    
    1: porque existe el metodo boot() en la clase User, porque se esta validando alli el password? no deria validarse esto en controlador con un formrequest?
*/

class RegisterController extends Controller
{

    use registerMessage;

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function register(RegisterRequest $request): JsonResponse
    {
            $result = $this->userService->createUser($request);

            return $this->sendResponse($result, 'User registered successfully.');
    }
}
