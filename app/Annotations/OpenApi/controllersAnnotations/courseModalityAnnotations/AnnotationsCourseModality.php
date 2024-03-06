<?php

namespace App\Annotations\OpenApi\controllersAnnotations\courseModalityAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsCourseModality
{
    /**
     * @OA\Get(
     *     path="/modality",
     *     summary="Retrieve the modality of a specific course",
     *     tags={"Course Modality"},
     *     @OA\Response(
     *         response=200,
     *             description="Successful operation",
     *             @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="modality", type="object",
     *                       @OA\Property(property="id", type="integer", example=1),
     *                       @OA\Property(property="name", type="string", example="Presencial")
     *                  )
     *             )
     *     )
     * )
     */
    public function __invoke() {}
}
