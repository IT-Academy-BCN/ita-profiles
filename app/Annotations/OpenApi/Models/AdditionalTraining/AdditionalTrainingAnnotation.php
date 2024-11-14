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
     *     format="uuid",
     *     example="a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11"   
     * )
     * @var string
     */
    public $id;

    /**
     * @OA\Property(
     *     property="course_name",
     *     description="Course Name",
     *     type="string",
     *     example="Python for Financial Data Analysis"
     * )
     * @var string
     */
    public $course_name;

    /**
     * @OA\Property(
     *     property="study_center",
     *     description="Study Center",
     *     type="string",
     *     example="FutureTech Learning Center"
     * )
     * @var string
     */
    public $study_center;

    /**
     * @OA\Property(
     *     property="course_beginning_year",
     *     description="Course Beginning Year",
     *     type="integer",
     *     format="int32",
     *     example="2022"
     * )
     * @var int
     */
    public $course_beginning_year;

    /**
     * @OA\Property(
     *     property="course_ending_year",
     *     description="Course Ending Year",
     *     type="integer",
     *     format="int32",
     *     example="2023"
     * )
     * @var int
     */
    public $course_ending_year;

    /**
     * @OA\Property(
     *     property="duration_hrs",
     *     description="Duration in Hours",
     *     type="integer",
     *     format="int32",
     *     example="250"
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
