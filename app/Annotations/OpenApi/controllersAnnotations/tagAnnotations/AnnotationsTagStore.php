<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\controllersAnnotations\tagAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsTagStore
{
    /**
     * @OA\Post(
     *     path="/tags",
     *     operationId="storeTag",
     *     tags={"Tags"},
     *     summary="Store a new tag.",
     *     description="Store a new tag in the database",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tag_name", type="string", example="New tag name"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="New tag created successfully.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="tag_name", type="string", example="Laravel"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-25T12:34:56Z"),
     *                 @OA\Property(property="message", type="string", example="Tag creada amb èxit."),
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Error: Unprocessable Content",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="La validació ha fallat."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="tag_name",
     *                     type="array",
     *                     @OA\Items(type="string", example="Tag name ja està registrat i no es pot repetir.")
     *                 )
     *             )
     *         ),
     *     ),
     * 
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Hi ha hagut un error")
     *         ),
     *     ),
     * )
     */
    public function __invoke() {}
}
