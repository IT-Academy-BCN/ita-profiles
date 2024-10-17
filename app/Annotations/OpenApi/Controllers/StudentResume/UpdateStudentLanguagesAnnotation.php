<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class UpdateStudentLanguagesAnnotation
{
    /**
     * @OA\Put (
     *     path="/student/{student}/resume/languages",
     *     operationId="updateLanguagesByStudentId",
     *     tags={"Student -> Resume"},
     *     summary="Actualitzar els idiomes de l'estudiant",
     *     description="Actualitzar els idiomes d'un estudiant donat el seu ID",
     *
     *     @OA\Parameter(
     *         name="student",
     *         in="path",
     *         description="ID de l'estudiant",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Català"
     *             ),
     *             @OA\Property(
     *                 property="level",
     *                 type="string",
     *                 enum={"Bàsic", "Intermedi", "Avançat", "Natiu"},
     *                 example="Intermedi"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Idioma actualitzat correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Idioma actualitzat correctament"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiant o idioma no trobat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Estudiant o idioma no trobat"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error de validació"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="S'ha produït un error mentre s'actualitzava l'idioma",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="S'ha produït un error mentre s'actualitzava l'idioma"
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
    }
}
