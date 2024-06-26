<?php

namespace App\Annotations\OpenApi\Controllers\SignInUser;

class SignInUserAnnotations
{
    
   
    /**
     * @OA\Post(
     *      path="/signin",
     *      operationId="signin",
     *      tags={"SignInUser"},
     *      summary="Signin",
     *      description="Sign in a user with their email and password.",
     *		
     *
     * 		@OA\Parameter(
     * 			name="dni",
     *         in="path",
     *         description="UUID of the student to get the resume modality",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *  	),
     * 		@OA\Parameter(
     *         
     * 
     * 			name="password",
     *         in="path",
     *         description="Password of related with the user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="dni", type="string", format="text", example="48332312C/Y4527507V"),
     *              @OA\Property(property="password", type="string", format="password", example="passOnePass")
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
     *              @OA\Property(property="userID", type="string", example="7"),
     *              @OA\Property(property="token", type="string", example="eyJ0e...")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="errors", type="object", example={{"errors":{"password":{"El camp contrasenya \u00e9s obligatori."}}}})
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Incorrect Password Or User",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="errors", type="object", example={{"message":"Wrong User Identication or Password"}})
     *          )
     *      ),
     *
     *
     *      ),
     * )
     */
    public function signin() {}
    
    
    
    
}
