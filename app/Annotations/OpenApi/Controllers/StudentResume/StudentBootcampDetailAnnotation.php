<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class StudentBootcampDetailAnnotation
{
    /**
     * @OA\Get(
     *      path="/student/{student}/resume/bootcamp",
     *      operationId="getStudentResumeBootcamp",
     *      tags={"Student -> Resume"},
     *      summary="Get a list of student's bootcamp/s",
     *      description="
- Returns a detailed list of a student's bootcamp(s) and the date(s) that they finished.
- Returns an empty array if the student hasn't finished any bootcamp yet.",
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
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="bootcamps",
     *                  type="array",
     *                  description="List of student's bootcamps",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="string",
     *                          description="Bootcamp ID",
     *                          example="9bd21470-db24-4ce3-b838-c4d3847785d1"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Bootcamp Name",
     *                          example="Fullstack PHP"
     *                      ),
     *                      @OA\Property(
     *                          property="end_date",
     *                          type="string",
     *                          description="Bootcamp end date",
     *                          example="2023-11-05"
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Student or Resume not found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No query results for model [App\\Models\\Student] {studentId}"
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="There was an error processing your request"
     *              )
     *          )
     *      )
     * )
     */
    public function __invoke() {}
}
