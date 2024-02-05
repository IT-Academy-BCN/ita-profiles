<?php

namespace App\Annotations\OpenApi\controllersAnnotations\roleListAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsRoleList
{
    /**
     * @OA\Get(
     *     path="/get-roles",
     *     summary="Roles Index",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Roles index retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="File not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function getRoleList() {}
}
