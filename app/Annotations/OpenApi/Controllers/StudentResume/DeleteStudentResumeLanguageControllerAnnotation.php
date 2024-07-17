<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class DeleteStudentResumeLanguageControllerAnnotation
{
    /**
     * @OA\Delete(
     *      path="/student/{studentId}/resume/languages/{languageId}",
     *      operationId="deleteStudentResumeLanguage",
     *      tags={"Student -> Resume"},
     *      summary="deletes a student's resume language",
     *      description="
-Deletes a student's resume language: You must provide a valid studentId and a valid languageId as parameters on the endpoint.

-Returns: It just returns a 200 status code when the language is deleted successfully.",
     *
     *      @OA\Parameter(
     *          name="studentId",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="languageId",
     *          description="Language ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid",
     *          )
     *      ),
     *
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *          )
     *      ),
     *
     *      @OA\Response(
     *               response=404,
     *               description="Student, Resume or Language not found",
     *               @OA\JsonContent(
     *                   @OA\Property(
     *                       property="message",
     *                       type="string",
     *                       example="No s'ha trobat cap estudiant amb aquest ID: {studentId}"
     *                   ),
     *                   @OA\Property(
     *                       property="message2",
     *                       type="string",
     *                       example="No s'ha trobat cap currículum per a l'estudiant amb id: {studentId}"
     *                   ),
     *                   @OA\Property(
     *                       property="message3",
     *                       type="string",
     *                       example="No s'ha trobat l'idioma amb id: [languageId] per a l'estudiant amb id: {studentId}"
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
     *                    example="El perfil de l'estudiant no s'ha pogut actualitzar, per favor el nou objectiu"
     *                    )
     *                )
     *            )
     *        )
     */
    public function __invoke()
    {
    }
}
