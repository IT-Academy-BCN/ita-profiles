<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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

            return response()->json(['message' => __('Logged in'), 'user' => $user->name, 'auth_token' => $token], 200);
        }

        throw new HttpResponseException(response()->json(['message' => __('Usuari o contrasenya incorrectes')], 401));
    }

    public function logout()
    {

        $user = Auth::user();

        $token = $user->token();
        $token->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
