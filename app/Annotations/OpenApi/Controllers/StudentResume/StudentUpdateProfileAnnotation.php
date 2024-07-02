<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class StudentUpdateProfileAnnotation
{
    /**
     * @OA\Put(
     *      path="/student/{studentId}/resume/profile",
     *      operationId="updateStudentProfile",
     *      tags={"Student -> Resume"},
     *      summary="Updates the student's profile by passing the studentId as a parameter on the endpoint",
     *      description="
- Update a student's profile: You must provide a valid studentId as a parameter on the endpoint. In the Request body there are already base data for the rest of the fields to test the endpoint, but you can change them if you want.

- Returns: A json message if the student's profile was updated or not.",
     *
     *      @OA\Parameter(
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
     *      @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Joe"),
     *              @OA\Property(property="surname", type="string", example="Doe"),
     *              @OA\Property(property="subtitle", type="string", format="string", example="Analista de Datos"),
     *              @OA\Property(property="github_url", type="string", example="https://github.com/joeDoe"),
     *              @OA\Property(property="linkedin_url", type="string", example="https://linkedin.com/joeDoe"),
     *              @OA\Property(property="about", type="string", example="lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum "),
     *          )
     *      ),
     *
     *       @OA\Response(
     *          response=200,
     *          description="El perfil del estudiante se actualizo correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="profile", type="string", example="El perfil del estudiante se actualizo correctamente"),
     *          )
     *      ),
     *
     *      @OA\Response(
     *               response=404,
     *               description="Student or Resume not found",
     *               @OA\JsonContent(
     *                   @OA\Property(
     *                       property="message",
     *                       type="string",
     *                       example="No s'ha trobat cap estudiant amb aquest ID: {studentId}"
     *                   ),
     *                   @OA\Property(
     *                       property="message2",
     *                       type="string",
     *                       example="No s'ha trobat cap currículum per a l\'estudiant amb id: {studentId}"
     *                   )
     *               )
     *        ),
     *
     *      @OA\Response(
     *               response=422,
     *               description="Unprocessable Content",
     *               @OA\JsonContent(
     *                   @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       example="El campo nombre es obligatorio."
     *                   ),
     *                   @OA\Property(
     *                       property="surname",
     *                       type="string",
     *                       example="El campo apellidos es obligatorio."
     *                   )
     *               )
     *        ),
     *
     *        @OA\Response(
     *                response=500,
     *                description="Server error",
     *                @OA\JsonContent(
     *                    @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="El perfil del estudiante no se pudo actualizar, por favor intentelo de nuevo"
     *                    )
     *                )
     *            )
     *        )
     */
    public function __invoke()
    {
    }
}
