<?php

namespace App\Annotations\OpenApi\controllersAnnotations\courseModalityAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsCourseModality
{
    /**
     * @OA\Get(
     *     path="/modality",
     *     operationId="getCourse;odality",
     *     summary="Get the modality of a specific course",
     *     description="Retrieve the modality of a specific course",
     *     tags={"Course Modality"},
     *     @OA\Response(
     *         response=200,
     *             description="Successful operation",
     *             @OA\JsonContent(
    *                   type="object",
    *                   @OA\Property(property="modality", type="string", example="Presencial")
     *             )
     *     )
     * )
     */
    public function __invoke() {}
}
