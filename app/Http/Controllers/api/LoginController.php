<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login",
     *      description="Log in a user with their email and password.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secretpassword")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Logged in"),
     *              @OA\Property(property="user", type="string", example="John Doe"),
     *              @OA\Property(property="auth_token", type="string", example="eyJ0e...")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Incorrect username or password")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}, "password": {"The password field is required."}})
     *          )
     *      ),
     * )
     */
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

            return response()->json(['message' => __('Autenticació amb èxit'), 'user' => $user->name, 'auth_token' => $token], 200);
        }

        throw new HttpResponseException(response()->json(['message' => __('Usuari o contrasenya incorrectes')], 401));
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      operationId="logout",
     *      tags={"Authentication"},
     *      summary="Logout",
     *      description="Log out the authenticated user.",
     *      security={{"passport": {}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successfully logged out",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Successfully logged out")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Unauthenticated")
     *          )
     *      ),
     * )
     */
    public function logout()
    {

        $user = Auth::user();

        $token = $user->token();
        $token->revoke();

        return response()->json(['message' => __('Desconnexió realitzada amb èxit')], 200);
    }
}
