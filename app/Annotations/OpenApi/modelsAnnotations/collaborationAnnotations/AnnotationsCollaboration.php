<?php

namespace App\Annotations\OpenApi\modelsAnnotations\collaborationAnnotations;


/**
 * @OA\Schema(
 *     schema="Collaboration",
 *     title="Collaboration",
 *     description="Collaboration Model",
 *     @OA\Xml(
 *         name="Collaboration"
 *     )
 * )
 */
class AnnotationsCollaboration {

    /**
     * @OA\Property(
     *     property="id",
     *     description="Collaboration ID",
     *     type="string",
     *     format="uuid"
     * )
     * @var string
     */
    public $id;

    /**
     * @OA\Property(
     *     property="collaboration_name",
     *     description="Collaboration Name",
     *     type="string"
     * )
     * @var string
     */
    public $collaboration_name;

    /**
     * @OA\Property(
     *     property="collaboration_description",
     *     description="Collaboration description",
     *     type="string"
     * )
     * @var string
     */
    public $collaboration_description;

    /**
     * @OA\Property(
     *     property="collaboration_quantity",
     *     description="Collaboration quantity",
     *     type="integer",
     *     format="int32"
     * )
     * @var int
     */
    public $collaboration_quantity;

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
