<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class StudentLanguagesDetailAnnotation
{
    /**
     * @OA\Get(
     *      path="/student/{student}/resume/languages",
     *      operationId="getStudentResumeLanguages",
     *      tags={"Student -> Resume"},
     *      summary="Gets the languages spoken by a student",
     *      description="This endpoint receives the UUID of a student and returns a detailed list of the languages ​​spoken by said student.

It returns a list of languages along with any other relevant information, such as the proficiency level in each language.",
     *
     *      @OA\Parameter(
     *          name="student",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Languages of the student found successfully.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="languages",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="string",
     *                          description="Language UUID",
     *                          example="e6b4432b-d2f8-4e06-b727-6ecaf40e6e0e"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Language name",
     *                          example="Anglès"
     *                      ),
     *                      @OA\Property(
     *                          property="level",
     *                          type="string",
     *                          description="The student's proficiency level in the language",
     *                          example="Bàsic"
     *                      ),
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
        *     response=404,
        *     description="Student or Resume not found",
        *     @OA\JsonContent(
        *         type="object",
        *         @OA\Property(property="message", type="string", example="No query results for model [App\Models\Student] {studentId}"),
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
