<?php

namespace App\Annotations\OpenApi\modelsAnnotations\adminAnnotations;

/**
 * @OA\Schema(
 *     title="Admin",
 *     description="Admin Model",
 *
 *     @OA\Xml(
 *         name="Admin"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     description="Admin ID",
 *     type="integer",
 *     format="int64"
 * )
 *
 * @var int
 *
 * @OA\Property(
 *     property="user_id",
 *     description="ID of the associated User",
 *     type="integer",
 *     format="int64"
 * )
 *
 * @var int
 *
 * @OA\Property(
 *     property="created_at",
 *     description="Creation date of the Admin record",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 *
 * @OA\Property(
 *     property="updated_at",
 *     description="Update date of the Admin record",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 */
class AnnotationsAdmin
{
}
