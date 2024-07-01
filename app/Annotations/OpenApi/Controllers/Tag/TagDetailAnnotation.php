<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\Tag;

use OpenApi\Annotations as OA;

class TagDetailAnnotation
{ 
    /**
    * @OA\Get(
    *      path="/tags/{tagId}",
    *      operationId="getTagDetailById",
    *      tags={"Tags"},
    *      summary="Get details of a specific tag",
    *      description="Retrieve details of a specific tag based on the provided ID.",
    *
    *
    *      @OA\Parameter(
    *          name="tagId",
    *          in="path",
    *          required=true,
    *          description="Tag ID",
    *
    *          @OA\Schema(type="integer", format="int64"),
    *      ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Tag details retrieved successfully.",
    *
    *         @OA\JsonContent(
    *
    *             type="object",
    *
    *           @OA\Property(
    *           property="data",
    *           type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
    *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
    *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
    *             )
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=404,
    *         description="Tag not found.",
    *
    *         @OA\JsonContent(
    *
    *             @OA\Property(property="message", type="string", example="Tag not found with id {tagId}."),
    *         ),
    *     ),
    *   )
    */
   public function __invoke() {}
}
