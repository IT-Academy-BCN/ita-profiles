<?php 
namespace App\Annotations\OpenApi\controllersAnnotations\developmentAnnotations;

class AnnotationsDevelopmentList
{
    /**
     * @OA\Get(
     *     path="/api/v1/development/list",
     *     summary="Retrieve a development list ",
     *     tags={"Development"},
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