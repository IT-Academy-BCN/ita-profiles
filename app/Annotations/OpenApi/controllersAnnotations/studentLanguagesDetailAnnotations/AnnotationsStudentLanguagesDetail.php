<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\studentLanguagesDetailAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsStudentLanguagesDetail
{
    /**
     * @OA\Get(
     *      path="/students/{uuid}/languages",
     *      operationId="getStudentLanguages",
     *      tags={"Languages"},
     *      summary="Get a detailed list of languages and their respective level from a specific student's resume",
     *      description="Returns a detailed list of languages and their respective level from a specific student's resume",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="Student UUID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="languages",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="language_id",
     *                          type="string",
     *                          description="Language UUID",
     *                          example="e6b4432b-d2f8-4e06-b727-6ecaf40e6e0e"
     *                      ),
     *                      @OA\Property(
     *                          property="language_name",
     *                          type="string",
     *                          description="Language name",
     *                          example="Anglès"
     *                      ),
     *                      @OA\Property(
     *                          property="language_level",
     *                          type="string",
     *                          description="Language level",
     *                          example="Bàsic"
     *                      ),
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
        *     response=404,
        *     description="Language not found or Student not found or Resume not found",
        *     @OA\JsonContent(
        *         type="object",
        *         @OA\Property(property="message", type="string", example="L'estudiant amb ID: {studentId} no té informat cap idioma al seu currículum"),
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

    public function __invoke() {}
}
