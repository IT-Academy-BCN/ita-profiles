<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class UpdateStudentCollaborationsControllerAnnotation
{
    /**
     * @OA\Put (
     *      path="/student/{studentId}/resume/collaborations",
     *      operationId="updateCollaborationsByStudentId",
     *      tags={"Student -> Resume"},
     *      summary="Update Student Collaborations numbers.",
     *      description="Update the numbers of collaborations of a given student by student ID",
     *
     *     @OA\Parameter(
     *          name="studentId",
     *          in="path",
     *          description="Student ID",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *            @OA\JsonContent(
     *               type="object",
     *               @OA\Property(property="collaborations", type="array",
     *
     *                   @OA\Items(
     *                       type="integer",
     *                       example=10
     *                   ),
     *               example={10, 20}
     *              ),
     *           )
     *       ),
     *
     *          @OA\Response(
     *          response=200,
     *          description="Collaborations updated successfully",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(
     *                   type="object",
     *
     *                   @OA\Property(
     *                       property="message",
     *                       type="string",
     *                       example="Collaborations updated successfully",
     *                   )
     *              )
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=404,
     *          description="No s'ha trobat cap estudiant amb aquest ID"
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *
     *      @OA\Response(
     *          response=500,
     *          description="Error inesperat"
     *      )
     * )
     */

    public function __invoke()
    {
    }

}
