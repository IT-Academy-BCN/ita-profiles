<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\studentResumeAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsModality
{
    /**
     * @OA\Get(
     *     path="/student/{studentId}/resume/modality/",
     *     operationId="getStudentResumeModality",
     *     summary="Get the modality of a specific resume",
     *     description="Returns the modality of a specific student's resume  ",
     *     tags={"Student -> Resume"},
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
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="modality",
     *                   type="array",
     *                   @OA\Items(type="string"),
     *                   example={"Presencial", "Remot"}
     *                   )
     *                )
     *     ),
     * @OA\Response(
     *     response=404,
     *     description="Modality not found or Student not found or Resume not found",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", example="L'estudiant amb ID: {studentId} no té informada la modalitat al seu currículum"),
     *         @OA\Property(property="message2", type="string", example="No s'ha trobat cap estudiant amb aquest ID {studentId}"),
     *         @OA\Property(property="message3", type="string", example="No s'ha trobat cap currículum per a l'estudiant amb id: {studentId}")
     *     )
     *     ),
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
    public function __invoke()
    {
    }
}
