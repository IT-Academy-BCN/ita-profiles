<?php

namespace App\Annotations\OpenApi\Models\AdditionalTraining;

/**
 * @OA\Schema(
 *     schema="AdditionalTraining",
 *     title="Additional Training",
 *     description="Additional Training Model",
 *     @OA\Xml(
 *         name="AdditionalTraining"
 *     )
 * )
 */
class AdditionalTrainingAnnotation {

    /**
     * @OA\Property(
     *     property="id",
     *     description="Additional Training ID",
     *     type="string",
     *     format="uuid"
     * )
     * @var string
     */
    public $id;

    /**
     * @OA\Property(
     *     property="course_name",
     *     description="Course Name",
     *     type="string"
     * )
     * @var string
     */
    public $course_name;

    /**
     * @OA\Property(
     *     property="study_center",
     *     description="Study Center",
     *     type="string"
     * )
     * @var string
     */
    public $study_center;

    /**
     * @OA\Property(
     *     property="course_beginning_year",
     *     description="Course Beginning Year",
     *     type="integer",
     *     format="int32"
     * )
     * @var int
     */
    public $course_beginning_year;

    /**
     * @OA\Property(
     *     property="course_ending_year",
     *     description="Course Ending Year",
     *     type="integer",
     *     format="int32"
     * )
     * @var int
     */
    public $course_ending_year;

    /**
     * @OA\Property(
     *     property="duration_hrs",
     *     description="Duration in Hours",
     *     type="integer",
     *     format="int32"
     * )
     * @var int
     */
    public $duration_hrs;

    /**
     * @OA\Property(
     *     property="created_at",
     *     description="Training creation date",
     *     type="string",
     *     format="date-time"
     * )
     * @var \Illuminate\Support\Carbon
     */
    public $created_at;

    /**
     * @OA\Property(
     *     property="updated_at",
     *     description="Training update date",
     *     type="string",
     *     format="date-time"
     * )
     * @var \Illuminate\Support\Carbon
     */
    public $updated_at;
}
