<?php

namespace App\Annotations\OpenApi\Controllers\Auth;

class RegisterRecruiterAnnotation
{
    /**
     * @OA\Post(
     *      path="/recruiter/register",
     *      operationId="registerRecruiter",
     *      summary="Register a new recruiter",
     *      tags={"RegisterRecruiter"},
     *      description="Register a new recruiter linked to a company. No authorization token is required for this endpoint.",
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="johnrecruiter"),
     *              @OA\Property(property="dni", type="string", example="65004204V"),
     *              @OA\Property(property="email", type="string", format="email", example="john.recruiter@example.com"),
     *              @OA\Property(property="password", type="string", example="Password@123"),
     *              @OA\Property(property="password_confirmation", type="string", example="Password@123"),
     *              @OA\Property(property="company_id", type="string", format="uuid", example="example-company-uuid"),
     *              @OA\Property(property="terms", type="boolean", example=true),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Recruiter registered successfully.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Recruiter registered successfully."),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="user", type="object",
     *                      @OA\Property(property="id", type="string", format="uuid", example="c03e0a50-6e38-4d3e-a95c-e13e06c42b75"),
     *                      @OA\Property(property="username", type="string", example="johnrecruiter"),
     *                      @OA\Property(property="dni", type="string", example="65004204V"),
     *                      @OA\Property(property="email", type="string", format="email", example="john.recruiter@example.com"),
     *                  ),
     *                  @OA\Property(property="recruiter", type="object",
     *                      @OA\Property(property="id", type="string", format="uuid", example="d04b0b32-3e51-4f95-b0b5-35d1f2c1a029"),
     *                      @OA\Property(property="company_id", type="string", format="uuid", example="9db0ba42-51d9-4957-a0a1-da22c2789be9"),
     *                      @OA\Property(property="user_id", type="string", format="uuid", example="c03e0a50-6e38-4d3e-a95c-e13e06c42b75"),
     *                      @OA\Property(property="role", type="string", example="recruiter"),
     *                  ),
     *                  @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="email", type="array",
     *                      @OA\Items(type="string", example="The email has already been taken.")
     *                  ),
     *                  @OA\Property(property="company_id", type="array",
     *                      @OA\Items(type="string", example="The selected company id is invalid.")
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="An unexpected error occurred."),
     *          )
     *      )
     * )
     */
    public function __invoke() {}
}
