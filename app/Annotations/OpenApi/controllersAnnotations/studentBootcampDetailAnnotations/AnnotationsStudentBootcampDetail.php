<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentBootcampDetailAnnotations;


use OpenApi\Annotations as OA;

class AnnotationsStudentBootcampDetail
{
    /**
     * @OA\Get(
     *      path="/api/v1/students/{id}/bootcamp",
     *      operationId="getStudentBootcamp",
     *      tags={"Bootcamp"},
     *      summary="Get a detailed list of a student bootcamp",
     *      description="Returns detail for a specific student bootcamp. (Note: This endpoint returns hardcoded bootcamp details)",
     *      @OA\Parameter(
     *          name="id",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(
     *                      property="bootcamp_id",
     *                      type="string",
     *                      description="Bootcamp ID"
     *                  ),
     *                  @OA\Property(
     *                      property="bootcamp_name",
     *                      type="string",
     *                      description="Bootcamp Name"
     *                  ),
     *                  @OA\Property(
     *                      property="bootcamp_site",
     *                      type="string",
     *                      description="Bootcamp Site"
     *                  ),
     *                  @OA\Property(
     *                      property="bootcamp_end_date",
     *                      type="array",
     *                      @OA\Items(type="string"),
     *                      description="Bootcamp end date"
     *                  ),
     *                  @OA\Property(
     *                      property="bootcamp_workload",
     *                      type="string",
     *                      description="Bootcamp Workload in hours"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Student not found"
     *      )
     * )
     */

    public function __invoke() {}
}
