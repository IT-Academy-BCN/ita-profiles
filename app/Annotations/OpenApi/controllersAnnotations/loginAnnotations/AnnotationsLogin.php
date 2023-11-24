<?php

namespace App\Annotations\OpenApi\controllersAnnotations\loginAnnotations;

class AnnotationsLogin
{
    /**
     * @OA\Post(
     *      path="api/v1/login",
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
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}, "password": {"The password field is required."}})
     *          )
     *      ),
     *
     *
     *      ),
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *      path="/logout",
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
     *
     *      ),
     * )
     */
    public function logout() {}
}
