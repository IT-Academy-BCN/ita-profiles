<?php

namespace App\Annotations\OpenApi\controllersAnnotations\modalityAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsModality
{
    /**
     * @OA\Get(
     *     path="/modality/{studentId}",
     *     operationId="invokeResume",
     *     summary="Get the modality of a specific resume",
     *     description="Returns the modality of a specific student's resume  ",
     *     tags={"Modality"},
     *     @OA\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="UUID of the student to get the resume modality",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
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
     *                   example={"Presencial", "Remoto"}
    *                   )
*                  )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resume not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="No se encontró el currículum del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Ha ocurrido un error")
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
    }
}
