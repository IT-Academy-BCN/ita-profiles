<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            /** @var \App\Models\User $user * */
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json(['message' => __('Autenticació amb èxit. Benvingut'), 'name' => $user->name, 'token' => $token], 200);
        }

        throw new HttpResponseException(response()->json(['message' => __('Email o contrasenya incorrecte')], 401));
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return response()->json(['message' => __('Desconnexió realitzada amb èxit')], 200);

    }
}
