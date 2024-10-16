<?php
declare(strict_types=1);
namespace App\Annotations\OpenApi\Controllers\StudentResume;

class UpdateStudentPhotoAnnotation
{
    /**
     * @OA\Post (
     *     path="/student/{studentId}/resume/photo",
     *     operationId="updatePhotoStudent",
     *     tags={"Student -> Resume"},
     *     summary="Update Student Photo.",
     *     description="Update the photo/image of a given student by student ID",
     * 
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
     *                 allOf={
     *                     @OA\Schema(ref="#components/schemas/item"),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             description="Item image",
     *                             property="photo",
     *                             type="string", format="binary"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Updates the photo.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *                  type="object",
     * 
     *                  @OA\Property(
     *                      property="photo",
     *                      type="string", format="binary"
     *                  )
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
     * 
     * )
     */
    public function __invoke() {}
}
