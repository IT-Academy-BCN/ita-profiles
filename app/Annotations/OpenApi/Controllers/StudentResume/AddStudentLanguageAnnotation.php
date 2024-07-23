<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/student/{studentId}/resume/languages",
 *     summary="Add a language to the student's resume",
 *     tags={"Student -> Resume"},
 *     description="Add a selected language from the languages table to the student's resume",
 *     @OA\Parameter(
 *         name="studentId",
 *         in="path",
 *         description="UUID of the student",
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
 *                 property="language_id",
 *                 description="UUID of the language",
 *                 type="string",
 *                 format="uuid"
 *             )
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=200,
 *         description="Language added successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="L'idioma s'ha afegit"
 *             )
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=404,
 *         description="Student or Resume not found",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="No s'ha trobat cap estudiant amb aquest ID {studentId}"
 *             ),
 *             @OA\Property(
 *                 property="message2",
 *                 type="string",
 *                 example="No s'ha trobat cap currículum per a l'estudiant amb id {studentId}"
 *             )
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=409,
 *         description="Language already exists",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="L'idioma {languageId} ja existeix al perfil de l'estudiant {studentId}"
 *             )
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=422,
 *         description="Invalid language UUID or Non-existent language UUID",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="errors",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="language_id",
 *                         type="string",
 *                         example="El language id ha de ser un indentificador únic universal (UUID) vàlid."
 *                     )
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="errors2",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="language_id",
 *                         type="string",
 *                         example="Language id és invàlid."           
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=500,
 *         description="Server Error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Hi ha hagut un error"
 *             )
 *         )
 *     )
 * )
 */
class AddStudentLanguageAnnotation
{
    public function __invoke()
    {
    }
}
