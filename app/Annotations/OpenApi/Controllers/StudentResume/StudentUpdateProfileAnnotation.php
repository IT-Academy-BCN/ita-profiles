<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class StudentUpdateProfileAnnotation
{
    /**
     * @OA\Get(
     *      path="/student/{studentId}/resume/profile",
     *      operationId="updateStudentProfile",
     *      tags={"Student -> Resume"},
     *      summary="Updates the student's profile by passing the studentId as a parameter on the endpoint",
     *      description="
- Returns a json message if the student's profile was updated or not.",
     *
     *      @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="user1"),
     *              @OA\Property(property="surname", type="string", example="Antonio"),
     *              @OA\Property(property="subtitle", type="string", format="string", example="Analista de Datos"),
     *              @OA\Property(property="github_url", type="string", example="https://github.com/AntonioMartinez"),
     *              @OA\Property(property="linkedin_url", type="string", example="https://linkedin.com/AntonioMartinez"),
     *              @OA\Property(property="about", type="string", example="lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum."),
     *          )
     *      ),
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
     *                       example="No se ha encontrado ningun estudiante con ID: {studentId}"
     *                   ),
     *                   @OA\Property(
     *                       property="message2",
     *                       type="string",
     *                       example="No se ha encontrado ningun curriculum para el estudiante con ID: {studentId}"
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
