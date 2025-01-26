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
     *             @OA\Property(property="username", type="string", example="john_doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="dni", type="string", example="65362114R"),
     *             @OA\Property(property="password", type="string", example="Password%123"),
     *             @OA\Property(property="company_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000", nullable=true),
     *             @OA\Property(property="terms", type="boolean", example=true)
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
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
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