<?php

namespace App\Annotations\OpenApi\Controllers\Auth;

class SignInUserAnnotations
{
    /**
     * @OA\Post(
     *      path="/signin",
     *      operationId="signin",
     *      tags={"SignInUser"},
     *      summary="Signin an existent user",
     *      description="Sign in a user with their DNI and password. **Important:** Erase one of the two DNIs (48332312C or Y4527507V) in the request body to test the endpoint.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="dni", type="string", format="text", example="48332312C/Y4527507V"),
     *              @OA\Property(property="password", type="string", format="password", example="passOnePass")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Logged in"),
     *              @OA\Property(property="userID", type="string", example="9d242f31-54a6-4f93-95f7-e1d7badbb44f"),
     *              @OA\Property(property="token", type="string", example="eyJ0e...")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="errors", type="object", example={{"errors":{"password":{"El camp contrasenya \u00e9s obligatori."}}}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Incorrect DNI or Password",
     *          @OA\JsonContent(
     *              @OA\Property(property="errors", type="object", example={{"message":"Wrong User Identication or Password"}})
     *          )
     *      ),
     * )
     */
    public function signin() {}
}
