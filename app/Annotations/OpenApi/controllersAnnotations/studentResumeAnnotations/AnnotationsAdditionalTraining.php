<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\studentResumeAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsAdditionalTraining
{
    /**
     * @OA\Get(
     *     path="/student/{studentId}/resume/additionaltraining",
     *     operationId="getStudentResumeAdditionalTraining",
     *     summary="Retrieve a list of additional training",
     *     description="Returns the additional training list of a specific student's resume  ",
     *     tags={"Student -> Resume"},
     *     @OA\Parameter(
     *         name="studentId",
     *         description="Student ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Additional training list retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="uuid", type="string", format="uuid"),
     *                 @OA\Property(property="course_name", type="string"),
     *                 @OA\Property(property="study_center", type="string"),
     *                 @OA\Property(property="course_beginning_year", type="integer"),
     *                 @OA\Property(property="course_ending_year", type="integer"),
     *                 @OA\Property(property="duration_hrs", type="integer"),
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *          response=404,
     *          description="Student or Resume not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="No s'ha trobat cap estudiant amb aquest ID {studentId}"),
     *              @OA\Property(property="message2", type="string", example="No s'ha trobat cap currículum per a l'estudiant amb id: {studentId}")
     *          )
     *     ),
     * 
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Hi ha hagut un error")
     *         )
     *     )
     * )
     */

    public function __invoke(){}
}
