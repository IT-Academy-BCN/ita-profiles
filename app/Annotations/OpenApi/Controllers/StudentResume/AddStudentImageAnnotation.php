<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class AddStudentImageAnnotation
{
    /**
     * @OA\Post (
     *     path="/student/{studentId}/resume/photo",
     *     operationId="addPhotoStudent",
     *     tags={"Student -> Resume"},
     *     summary="Add Student Photo.",
     *     description="Add a photo/image for a given student by student ID",
     * 
     *     @OA\Parameter(
     *         name="studentId",
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
     *                 required={"photo"}, 
     *                 @OA\Property(
     *                     property="photo",
     *                     description="Item image",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Adds the photo.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="La imatge s'ha afegit correctament" 
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hem trobat cap estudiant amb aquest ID"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * )
     */
    public function __invoke() {}
}
