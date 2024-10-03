<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class StudentDetailAnnotation
{
    /**
     * @OA\Get (
     *     path="/student/{student}/resume/detail",
     *     operationId="getStudentDetailsResumeAbout",
     *     tags={"Student -> Resume"},
     *     summary="Get Student Detail.",
     *     description="Retrieve details of a specific student. No authentication required.",
     *     @OA\Parameter(
     *         name="student",
     *         in="path",
     *         description="Student ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the student details.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
     *                 @OA\Property(property="fullname", type="string", example="Katrine Wyman Jacobson"),
     *                 @OA\Property(property="photo", type="string", nullable=true, example="https://example.com/photo.jpg"),
     *                 @OA\Property(property="status", type="string", enum={"Active", "Inactive", "In a Bootcamp", "In a Job"}, example="Active"),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=4),
     *                         @OA\Property(property="name", type="string", example="HTML&CSS")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="resume",
     *                     type="object",
     *                     @OA\Property(property="subtitle", type="string", example="Full Stack developer en PHP"),
     *                     @OA\Property(
     *                         property="modality",
     *                         type="array",
     *                         @OA\Items(
     *                             type="string",
     *                             example="Remote"
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="social_media",
     *                         type="object",
     *                         @OA\Property(property="github", type="string", example="https://github.com/bettie52"),
     *                         @OA\Property(property="linkedin", type="string", example="https://linkedin.com/abernathy.dayne")
     *                     ),
     *                     @OA\Property(property="about", type="string", example="Iusto aut debitis soluta facere tempore quisquam. Vel assumenda aliquid quod et eum quos ex. Ipsa ea tempora minima occaecati. Culpa occaecati quod laboriosam reiciendis quia consequuntur.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hem trobat cap estudiant amb aquest ID"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * )
     */
    public function __invoke() {}
}
