<?php

namespace App\Annotations\OpenApi\controllersAnnotations\tagAnnotations;

class AnnotationsTag
{
    /**
     * @OA\Post(
     *      path="/tags",
     *      operationId="createTag",
     *      tags={"Tags"},
     *      summary="Create a new tag",
     *      description="Creates a new tag.",
     *
     *      @OA\RequestBody(
     *            required=true,
     *
     *            @OA\JsonContent(
     *            type="object",
     *
     *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
     *           )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Tag created successfully.",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Tag created successfully.")
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error creating the tag.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Error creating the tag. Please try again."),
     *         ),
     *     ),
     * )
     */
    public function store() {}


}
