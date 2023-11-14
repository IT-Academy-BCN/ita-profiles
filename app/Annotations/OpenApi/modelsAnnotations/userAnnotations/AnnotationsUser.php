<?php

namespace App\Annotations\OpenApi\modelsAnnotations\userAnnotations;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User Model",
 *
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     description="User ID",
 *     type="integer",
 *     format="int64"
 * )
 *
 * @var int
 *
 * @OA\Property(
 *     property="name",
 *     description="User's first name",
 *     type="string",
 * example="John"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="surname",
 *     description="User's last name",
 *     type="string",
 * example="Doe"
 *
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="dni",
 *     description="User's DNI",
 *     type="string",
 *     example="12345678B"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="email",
 *     description="User's email address",
 *     type="string",
 *     format="email",
 *   example="johndoe@example.com"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="password",
 *     description="User's password",
 *     type="string",
 *     format="password",
 *     example="********"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="created_at",
 *     description="User's creation date",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 *
 * @OA\Property(
 *     property="updated_at",
 *     description="User's update date",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 *
 * @OA\Property(
 *     property="email_verified_at",
 *     description="User's email verification date",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon|null
 */
class AnnotationsUser {}
