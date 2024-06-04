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
     *     @OA\Parameter(
     *         name="tagId",
     *         in="path",
     *         required=true,
     *         description="ID of the tag to be updated.",
     *         @OA\Schema(type="integer", format="int64"),
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="New Tag name.

- Tag field is **required**, must be a **string**, **less than 75 characters** and **unique** on database",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *               property="tag_name",
     *               type="string",
     *               example="Updated Tag"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tag updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tag", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Tag not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *               property="message",
     *               type="string",
     *               example="No s'ha trobat cap etiqueta amb aquest ID: {tagId}"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El camp tag name és obligatori."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="tag_name", type="array",
     *                     @OA\Items(type="string", example="El camp tag name és obligatori.")
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function __invoke() {}
}
