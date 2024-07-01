<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\Tag;

use OpenApi\Annotations as OA;

class TagListAnnotation
{
     /**
   * @OA\Get(
   *     path="/tags",
   *     operationId="getTagList",
   *     tags={"Tags"},
   *     summary="Get tag list",
   *     description="Retrieve a list of registered tags.",
   *
   *     @OA\Response(
   *         response=200,
   *         description="Successful. Tag list retrieved.",
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(
   *                 property="tags",
   *                 type="array",
   *                 @OA\Items(
   *                     type="object",
   *                     @OA\Property(property="id", type="integer", example=1),
   *                     @OA\Property(property="tag_name", type="string", example="Laravel"),
   *                 )
   *             )
   *         )
   *     ),
   *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Hi ha hagut un error")
     *         )
     *     )
   * )
   */
   public function __invoke() {}
}
