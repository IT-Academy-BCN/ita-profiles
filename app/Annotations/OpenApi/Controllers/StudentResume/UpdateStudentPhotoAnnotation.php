<?php
declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class UpdateStudentPhotoAnnotation
{
    /**
     * @OA\Post(
     *     path="/student/{student}/resume/photo",
     *     operationId="updatePhotoStudent",
     *     tags={"Student -> Resume"},
     *     summary="Update Student Photo",
     *     description="Update the photo/image of a given student by student ID",
     * 
     *     @OA\Parameter(
     *         name="student",
     *         in="path",
     *         description="Student ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     * 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="photo",
     *                     type="string",
     *                     format="binary",
     *                     description="Student photo"
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Photo updated.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Photo updated successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Student not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Unexpected error"
     *     )
     * )
     */
    public function __invoke() {}
}
