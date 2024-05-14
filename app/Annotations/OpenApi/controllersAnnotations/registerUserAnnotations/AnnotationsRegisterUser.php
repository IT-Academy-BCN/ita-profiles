<?php

namespace App\Annotations\OpenApi\ControllersAnnotations\RegisterUserAnnotations;

class AnnotationsRegisterUser
{
    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="registerUser",
     *      summary="Register a new user",
     *      tags={"UserRegister"},
     *
     *
     * 		@OA\Parameter(
     * 			name="username",
     *         in="path",
     *         description="Username of the new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *  	),
     *
     *      @OA\Parameter(
     * 			name="dni",
     *         in="path",
     *         description="DNI/NIE of the new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *  	),
     *
     *      @OA\Parameter(
     * 			name="email",
     *         in="path",
     *         description="Email of the new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="email"
     *         ),
     *  	),
     *
     *      @OA\Parameter(
     *          name="specialization",
     *          in="path",
     *          description="Specialization of the new user",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *
     * 		@OA\Parameter(
     * 			name="password",
     *         in="path",
     *         description="Password of the new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="password"
     *         ),
     *     ),
     *
     *      @OA\Parameter(
     * 			name="password_confirmation",
     *         in="path",
     *         description="Password confirmation",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="password"
     *         ),
     *     ),

     *      @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="user1"),
     *              @OA\Property(property="dni", type="string", example="12345678A"),
     *              @OA\Property(property="email", type="string", format="email", example="user1@user.com"),
     *              @OA\Property(property="specialization", type="string", example="FrontEnd"),
     *              @OA\Property(property="password", type="string", example="123456789"),
     *              @OA\Property(property="password_confirmation", type="string", example="123456789"),
     *          )
     *      ),
     *
     *       @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="token", type="string", example="enGJ56Bvbhb56fCVJftbGciOiJSUzI1NiJ9"),
     *              @OA\Property(property="email", type="string", example="user1@user.com"),
     *          )
     *      ),
     *
     *
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
