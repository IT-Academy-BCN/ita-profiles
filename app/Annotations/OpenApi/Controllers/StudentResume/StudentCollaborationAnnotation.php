<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class StudentCollaborationAnnotation
{
    /**
     * @OA\Get(
     *     path="/student/{student}/resume/collaborations",
     *     operationId="getStudentResumeCollaborations",
     *     summary="Retrieve a list of collaborations",
     *     tags={"Student -> Resume"},
     *     description="Retrieve collaborations details of a specific student. No authentication required.",
     *
     *
     *     @OA\Parameter(
     *         name="student",
     *         description="Student ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="Successful. Collaboration list retrieved",
     *         @OA\JsonContent(
     *         type="object",
     *             @OA\Property(
     *                 property="collaborations",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="uuid",
     *                         type="string",
     *                         description="Collaboration UUID",
     *                         example="e6b4432b-d2f8-4e06-b727-6ecaf40e6e0e"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Name of the collaboration",
     *                         example="Project X"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Description of the collaboration",
     *                         example="A collaborative project on topic Y"
     *                     ),
     *                     @OA\Property(
     *                         property="quantity",
     *                         type="integer",
     *                         description="Quantity of the collaboration",
     *                         example=3
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=404,
     *          description="Student or Resume not found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No s'ha trobat cap estudiant amb aquest ID {student}"
     *              ),
     *              @OA\Property(
     *                  property="message2",
     *                  type="string",
     *                  example="No s'ha trobat cap currículum per a l'estudiant amb id: {student}"
     *              )
     *          )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="There was a server error")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
