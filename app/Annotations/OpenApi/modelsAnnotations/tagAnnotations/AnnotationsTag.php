<?php

namespace App\Annotations\OpenApi\modelsAnnotations\tagAnnotations;

/**
 * @OA\Schema(
 *     title="Tag",
 *     description="Tag Model",
 *
 *     @OA\Xml(
 *         name="Tag"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     description="Tag ID",
 *     type="integer",
 *     format="int64"
 * )
 *
 * @var int
 *
 * @OA\Property(
 *     property="tag_name",
 *     description="Tag Name",
 *     type="string",
 *     format="int64"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="created_at",
 *     description="Tag creation date",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 *
 * @OA\Property(
 *     property="updated_at",
 *     description="Tag update date",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 */
class AnnotationsTag {}
