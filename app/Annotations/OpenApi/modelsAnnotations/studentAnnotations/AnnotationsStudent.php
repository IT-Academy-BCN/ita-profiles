<?php

namespace App\Annotations\OpenApi\modelsAnnotations\studentAnnotations;

/**
 * @OA\Schema(
 *     title="Student",
 *     description="Student Model",
 *
 *     @OA\Xml(
 *         name="Student"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     description="Student ID",
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
 *     property="subtitle",
 *     description="Presentation subtitle of the Student",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="about",
 *     description="Presentation text of the Student",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="cv",
 *     description="Curriculum of the Student-file?",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="bootcamp",
 *     description="Name of the Bootcamp attended by the Student",
 *     type="enum"
 * )
 * @OA\Property(
 *     property="end_date",
 *     description="Student Bootcamp's ending date",
 *     type="date"
 * )
 *
 * @var date
 *
 * @OA\Property(
 *     property="linkedin",
 *     description="Url of student's linkedin",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="github",
 *     description="Url of student's github",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="created_at",
 *     description="Creation date of the Student record",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 *
 * @OA\Property(
 *     property="updated_at",
 *     description="Update date of the Student record",
 *     type="string",
 *     format="date-time"
 * )
 *
 * @var \Illuminate\Support\Carbon
 */
class AnnotationsStudent
{
}
