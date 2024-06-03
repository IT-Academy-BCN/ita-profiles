<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\tagAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsTagUpdate
{
    /**
     * @OA\Put(
     *     path="/tags/{tagId}",
     *     operationId="updateTag",
     *     tags={"Tags"},
     *     summary="Update details of a specific tag.",
     *     description="Updates details of a specific tag based on the provided ID.",
     *
     *     @OA\Parameter(
     *         name="tagId",
     *         in="path",
     *         required=true,
     *         description="ID of the tag to be updated",
     *
     *         @OA\Schema(type="integer", format="int64"),
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="tag_name", type="string", example="Updated Tag"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tag details retrieved successfully.",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object",
     *
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
     *                 @OA\Property(property="message", type="string", example="Tag updated successfully."),
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
     *             @OA\Property(property="message", type="string", example="Tag not found."),
     *         ),
     *     ),
     * )
     */
    public function __invoke() {}
}
