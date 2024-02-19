<?php

namespace App\Annotations\OpenApi\modelsAnnotations\resumeAnnotations;

/**
 * @OA\Schema(
 *     title="Resume",
 *     description="Resume Model",
 *
 *     @OA\Xml(
 *         name="Resume"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     description="Resume UUID",
 *     type="string",
 *     format="uuid"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="student_id",
 *     description="ID of the associated students",
 *     type="string",
 *
 * )
 *
 * @var string
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
 *     property="linkedin_url",
 *     description="Url of student's linkedin",
 *     type="url"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="github_url",
 *     description="Url of student's github",
 *     type="string"
 * )
 *
 * @var string
 *
 * @OA\Property(
 *     property="specialization",
 *     description="Student Bootcamp's specialization",
 *     type="enum"
 * )
 * @OA\Property(
 *     property="tags_ids",
 *     description="List of student's tags",
 *     type="json"
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
class AnnotationsResume
{
}
