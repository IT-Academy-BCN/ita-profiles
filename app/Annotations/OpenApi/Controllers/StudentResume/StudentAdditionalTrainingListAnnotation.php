<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class StudentAdditionalTrainingListAnnotation
{
/**
 * @OA\Get(
 *     path="/student/{studentId}/resume/additionaltraining",
 *     operationId="getStudentResumeAdditionalTraining",
 *     summary="Retrieve a list of additional training",
 *     tags={"Student -> Resume"},
 *
 *
 *          @OA\Parameter(
 *          name="studentId",
 *          description="Student ID",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              format="uuid"
 *          )
 *      ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful. Additional training list retrieved",
 *         @OA\JsonContent(
 *             type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="uuid", type="string", format="uuid"),
 *                     @OA\Property(property="course_name", type="string"),
 *                     @OA\Property(property="study_center", type="string"),
 *                     @OA\Property(property="course_beginning_year", type="integer"),
 *                     @OA\Property(property="course_ending_year", type="integer"),
 *                     @OA\Property(property="duration_hrs", type="integer"),
 *                 )
 *             )
 *         )
 *     )
 * )
 */

    public function __invoke(){}
}
