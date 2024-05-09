<?php

namespace App\Annotations\OpenApi\controllersAnnotations\homeFilterLists;

use OpenApi\Annotations as OA;

class AnnotationsSpecializationList
{
    /**
     * @OA\Get(
     *     path="/specialization/list",
     *     summary="Retrieve a specialization list from resume model enum",
     *     tags={"Home Filter Lists"},
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
