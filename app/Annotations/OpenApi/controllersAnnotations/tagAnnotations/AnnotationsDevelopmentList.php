<?php
namespace App\Annotations\OpenApi\controllersAnnotations\tagAnnotations;

class AnnotationsDevelopmentList
{
    /**
     * @OA\Get(
     *     path="/development/list",
     *     summary="Retrieve a development list ",
     *     tags={"Filter List"},
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
