<?php
namespace App\Annotations\OpenApi\Controllers\Tag;

class DevelopmentListAnnotation
{
    /**
     * @OA\Get(
     *     path="/development/list",
     *     summary="Retrieve a development list ",
     *     tags={"Tags"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful. Development list retrieved from json file",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
