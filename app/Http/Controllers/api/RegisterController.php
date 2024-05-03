<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\registerRequest;
use Illuminate\Http\JsonResponse;
use Service\User\registerMessage;
use Service\User\UserService;

/* TODO: En  el formulario de registro(imagen de la tarjeta #136) hay campos que no corresponden con la tabla users/students en la BBDD: 
    -En el formulario faltaria: los campos surname(por cierto este campo esta repetido tanto en la tabla user como en la de students en la BBDD al igual que el name) y especializacion .
     
    PREGUNTA: porque existe el metodo boot() en la clase User, porque se esta validando alli el password? no deria validarse esto en controlador con un formrequest?
*/

/*
🗒️NOTAS:
    1: Es mejor instanciar el UserService dentro del metodo register() y no en el constructor, pues si se hace en el constructor se crea un registro en la BBDD antes de hacer la validacion en registerRequest y daria error de duplicated dni aunque sea un usuario nuevo.
*/

class RegisterController extends Controller
{

    use registerMessage;

    public function register(registerRequest $request): JsonResponse
    {
        $userService = new UserService();/*nota 1*/
        $response = $userService->register($request);

        return $this->sendResponse($response, 'User registered successfully.');
    }


}
