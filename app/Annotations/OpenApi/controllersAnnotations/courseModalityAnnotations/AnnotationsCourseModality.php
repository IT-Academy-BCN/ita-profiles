<?php

namespace App\Annotations\OpenApi\controllersAnnotations\courseModalityAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsCourseModality
{
    /**
     * @OA\Get(
     *     path="/modality",
     *     summary="Retrieve the modality of a specific student",
     *     tags={"Modality"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Modality retrieved from enum",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}