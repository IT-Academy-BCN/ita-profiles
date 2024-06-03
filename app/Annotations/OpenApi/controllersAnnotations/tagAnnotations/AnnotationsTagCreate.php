<?php

namespace App\Annotations\OpenApi\controllersAnnotations\tagAnnotations;

class AnnotationsTagCreate
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
     *            description="New Tag name.

- Tag field is **required**, must be a **string**, **less than 75 characters** and **unique** on database",
     *            @OA\JsonContent(
     *            type="object",
     *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
     *            )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Tag created successfully.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="tag", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="tag_name", type="string", example="New Tag Name")
     *              )
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="tag_name", type="array",
     *                     @OA\Items(type="string", example="The tag_name field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error creating the tag.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error creating the tag. Please try again."),
     *         ),
     *     ),
     * )
     */
    public function __invoke() {}
}
