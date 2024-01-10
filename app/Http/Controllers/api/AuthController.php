<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('dni', 'password');

            $user = $this->verifyUser($credentials);
            /** @var \App\Models\User $user * */
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json([
                'message' => __('Autenticació amb èxit. Benvingut'),
                'name' => ucwords($user->name),
                'token' => $token
            ], 200);

        } catch (Exception $validationException) {
            return response()->json(
                ['message' => __($validationException->getMessage())],
                $validationException->getCode()
            );
        }
    }

    private function verifyUser(array $credentials)
    {

        if (!Auth::attempt($credentials)) {
            throw new Exception(__('Credencials invàlides, comprova-les i torneu a iniciar sessió'), 401);

        }
        return Auth::user();
    }



    public function logout()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user * */
        $user->tokens()->delete();

        return response()->json(['message' => __('Desconnexió realitzada amb èxit')], 200);

    }
}
