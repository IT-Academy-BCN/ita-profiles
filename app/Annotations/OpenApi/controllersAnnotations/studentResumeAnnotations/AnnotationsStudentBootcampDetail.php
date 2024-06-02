<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\studentResumeAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsStudentBootcampDetail
{
    /**
     * @OA\Get(
     *      path="/student/{studentId}/resume/bootcamp",
     *      operationId="getStudentResumeBootcamp",
     *      tags={"Student -> Resume"},
     *      summary="Get a list of student´s bootcamp/s",
     *      description="
- Returns detailed list of a student's bootcamp/s and the date that was/were finished.
- Returns an empty array if the student didn't finish any bootcamp yet.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="bootcamps",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="bootcamp_id",
     *                          type="string",
     *                          description="Bootcamp ID",
     *                          example="9bd21470-db24-4ce3-b838-c4d3847785d1"
     *                      ),
     *                      @OA\Property(
     *                          property="bootcamp_name",
     *                          type="string",
     *                          description="Bootcamp Name",
     *                          example="Fullstack PHP"
     *                      ),
     *                      @OA\Property(
     *                          property="bootcamp_end_date",
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
     *               response=404,
     *               description="Student or Resume not found",
     *               @OA\JsonContent(
     *                   @OA\Property(
     *                       property="message",
     *                       type="string",
     *                       example="No s'ha trobat cap estudiant amb aquest ID {studentId}"
     *                   ),
     *                   @OA\Property(
     *                       property="message2",
     *                       type="string",
     *                       example="No s'ha trobat cap currículum per a l'estudiant amb id: {studentId}"
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
     *                    example="Hi ha hagut un error"
     *                    )
     *                )
     *            )
     *        )
     */
    public function __invoke()
    {
    }
}
