<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentResumeAnnotations;

class AnnotationsStudentDetail
{
    /**
     * @OA\Get (
     *     path="/student/{studentId}/resume/detail",
     *     operationId="getStudentDetailsResumeAbout",
     *     tags={"Student -> Resume"},
     *     summary="Get Student Detail.",
     *     description="Retrieve details of a specific student. No authentication required.",
     *     @OA\Parameter(
     *         name="studentId",
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
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="fullname", type="string", example="Katrine Wyman Jacobson"),
     *                     @OA\Property(property="subtitle", type="string", example="Full Stack developer en PHP"),
     *                     @OA\Property(
     *                         property="social_media",
     *                         type="object",
     *                         @OA\Property(
     *                             property="github",
     *                             type="object",
     *                             @OA\Property(property="url", type="string", example="https://github.com/bettie52")
     *                         ),
     *                         @OA\Property(
     *                             property="linkedin",
     *                             type="object",
     *                             @OA\Property(property="url", type="string", example="https://linkedin.com/abernathy.dayne")
     *                         )
     *                     ),
     *                     @OA\Property(property="about", type="string", example="Iusto aut debitis soluta facere tempore quisquam. Vel assumenda aliquid quod et eum quos ex. Ipsa ea tempora minima occaecati. Culpa occaecati quod laboriosam reiciendis quia consequuntur."),
     *                     @OA\Property(
     *                         property="tags",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example=4),
     *                             @OA\Property(property="name", type="string", example="HTML&CSS")
     *                         )
     *                     )
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
