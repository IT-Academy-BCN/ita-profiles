<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentCollaborationAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsStudentCollaboration
{
    /**
     * @OA\Get(
     *      path="/api/v1/studentCollaborations",
     *      operationId="getStudentCollaborations",
     *      tags={"Collaborations"},
     *      summary="Get collaborations for a student",
     *      description="Returns a list of collaborations for a specific student. (Note: This endpoint returns hardcoded student collaborations)",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *
     *                  @OA\Property(
     *                      property="collaborations",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1, description="Collaboration ID"),
     *                          @OA\Property(property="name", type="string", example="ita wiki", description="Collaboration name"),
     *                          @OA\Property(property="description", type="string", example="Recursos subidos", description="Collaboration description"),
     *                          @OA\Property(property="quantity", type="integer", example=9, description="Quantity"),
     *                      ),
     *                      
     *                  ),
     *
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

