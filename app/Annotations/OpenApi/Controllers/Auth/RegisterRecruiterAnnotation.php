<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\Auth;

class RegisterRecruiterAnnotation
{
    /**
     * @OA\Post (
     *     path="/api/v1/recruiter/register",
     *     operationId="registerRecruiter",
     *     tags={"Recruiter"},
     *     summary="Register a new recruiter",
     *     description="Registers a new recruiter with the provided details.",
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             required={"username", "email", "dni", "password", "password_confirmation", "terms"},
     *             @OA\Property(property="username", type="string", example="john_doe", description="Recruiter's username"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Recruiter's email"),
     *             @OA\Property(property="dni", type="string", example="65362114R", description="Recruiter's DNI"),
     *             @OA\Property(property="password", type="string", format="password", example="Password%123", description="Recruiter's password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Password%123", description="Password confirmation"),
     *             @OA\Property(property="company_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000", nullable=true, description="Company ID associated with the recruiter"),
     *             @OA\Property(property="terms", type="boolean", example=true, description="Acceptance of terms and conditions")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=201,
     *         description="Recruiter registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Recruiter created successfully"),
     *             @OA\Property(property="recruiter", type="object", example={"id": "123e4567-e89b-12d3-a456-426614174000"}),
     *             @OA\Property(property="user", type="object", example={"id": "456e1234-e89b-34c3-a456-456e671d432f"}),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email has already been taken."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Role 'recruiter' not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
