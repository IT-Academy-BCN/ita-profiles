<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class StudentAdditionalTrainingListAnnotation
{
    /**
     * @OA\Get(
     *     path="/student/{student}/resume/additionaltraining",
     *     operationId="getStudentResumeAdditionalTraining",
     *     summary="Retrieve a detailed list of additional trainings for a specific student from resume",
     *     tags={"Student -> Resume"},
     *
     *     @OA\Parameter(
     *          name="student",
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
     *         description="Successful. Additional training list retrieved for a student from resume",
     *         @OA\JsonContent(
     *             type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
     *                     @OA\Property(property="course_name", type="string", example="Python for Financial Data Analysis"),
     *                     @OA\Property(property="study_center", type="string", example="FutureTech Learning Center"),
     *                     @OA\Property(property="course_beginning_year", type="integer", example="2022"),
     *                     @OA\Property(property="course_ending_year", type="integer", example="2023"),
     *                     @OA\Property(property="duration_hrs", type="integer", example="250"),
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Student not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Empty additional training list when no resume or trainings found",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(),
     *             example={}
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
