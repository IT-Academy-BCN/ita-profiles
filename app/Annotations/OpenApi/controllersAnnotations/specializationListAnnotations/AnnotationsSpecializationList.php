<?php

namespace App\Annotations\OpenApi\controllersAnnotations\specializationListAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsSpecializationList
{
    /**
     * @OA\Get(
     *     path="/api/v1/specialization/list",
     *     summary="Retrieve a specialization list from resume model enum",
     *     tags={"Specialization"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Specialization list retrieved from enum",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
