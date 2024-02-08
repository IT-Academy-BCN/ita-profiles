<?php

namespace App\Annotations\OpenApi\controllersAnnotations\specializationListAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsSpecializationList
{
    /**
     * @OA\Get(
     *     path="/api/v1/specialization/list",
     *     summary="Specialization list",
     *     tags={"Specialization"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Specialization list retrieved",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(type="string")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
