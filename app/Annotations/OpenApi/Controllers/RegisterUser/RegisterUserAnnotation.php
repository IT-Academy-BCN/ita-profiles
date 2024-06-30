<?php

namespace App\Annotations\OpenApi\Controllers\RegisterUser;

class RegisterUserAnnotation
{
    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="registerUser",
     *      summary="Register a new user",
     *      tags={"UserRegister"},
     *     description="
- Create a new user: In the Request body there are already base data to test the endpoint but you can change them if you want.
- Returns: the user token and the user email if the user was created successfully.",
     *
     *      @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="user1"),
     *              @OA\Property(property="dni", type="string", example="12345678Z"),
     *              @OA\Property(property="email", type="string", format="email", example="user1@user.com"),
     *              @OA\Property(property="specialization", type="string", example="Frontend"),
     *              @OA\Property(property="password", type="string", example="Password%123"),
     *              @OA\Property(property="password_confirmation", type="string", example="Password%123"),
     *              @OA\Property(property="terms", type="string", example="true"),
     *          )
     *      ),
     *
     *       @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="token", type="string", example="enGJ56Bvbhb56fCVJftbGciOiJSUzI1NiJ9"),
     *              @OA\Property(property="email", type="string", example="user1@user.com"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object"),
     *          )
     *       ),
     *
     *
     *      @OA\Response(
     *         response=404,
     *         description="Register was not succesful.Please try it again later."
     *      ),
     *
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Internal server error"),
     *         ),
     *     ),
     * )
     */
     public function register() {}
}
