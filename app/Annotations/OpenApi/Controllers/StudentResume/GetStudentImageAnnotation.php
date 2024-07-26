<?php
declare(strict_types=1);
namespace App\Annotations\OpenApi\Controllers\StudentResume;

class GetStudentImageAnnotation
{
    /**
     * @OA\Get (
     *     path="/student/{studentId}/resume/photo",
     *     operationId="getStudentProfileImage",
     *     tags={"Student -> Resume"},
     *     summary="Get the Student Profile Photo.",
     *     description="Get the photo/image of a given student by student ID",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="photo",
     *                 oneOf={
     *                     @OA\Schema(type="string", example="/storage/photos/https://www.example.com/photo.jpg"),
     *                     @OA\Schema(type="null")
     *                 }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error del servidor"
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
