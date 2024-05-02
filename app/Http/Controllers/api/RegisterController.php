<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\registerRequest;
use Service\User\registerMessage;
use Service\User\userService;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class RegisterController extends Controller
{
    use registerMessage;
    public function register(registerRequest $request)
    {
        // echo "estas en registerController";
        // dd($request);

        $register = new userService();
        $register->register($request);

        return response()->json([], 204);


    }

    // public function register(Request $request): JsonResponse
    // {
    //     // Validar los datos recibidos en la solicitud
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:8',
    //         'password_confirmation' => 'required|same:password',
    //     ]);

    //     // var_dump($validator);

    //     // Si la validación falla, se retorna un error con los detalles
    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }
    //     // Obtener todos los datos de la solicitud
    //     $input = $request->all();
    //     // Encriptar la contraseña antes de almacenarla en la base de datos
    //     $input['password'] = bcrypt($input['password']);
    //     // Crear un nuevo usuario con los datos proporcionados
    //     $user = User::create($input);
    //     // Generar un token de acceso para el usuario recién registrado
    //     $success['token'] = $user->createToken('MyApp')->accessToken;
    //     $success['email'] = $user->email;
        
    //     // Retornar una respuesta exitosa con el token y el nombre del usuario
    //     return $this->sendResponse($success, 'User registered successfully.');
    // }

}
