<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class SpecializationListAnnotation
{
    /**
     * @OA\Get(
     *     path="/specialization/list",
     *     summary="Retrieve a specialization list from resume model enum",
     *     tags={"Student -> Resume"},
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
