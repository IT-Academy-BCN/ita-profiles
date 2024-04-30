<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentAnnotations;

class AnnotationsStudentDetail
{
    /**
     *
     *
     * @OA\Get (
     *     path="/student/{id}/detail/for-home",
     *     operationId="getStudentDetails",
     *     tags={"Student"},
     *     summary="Get details of a Student.",
     *     description="Get the details of a specific student. Authentication is not required.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the student",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="Success. Returns student details with about.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *
     *                 @OA\Items(
     *                     type="object",
     *
     *                     @OA\Property(property="name", type="string", example="John"),
     *                     @OA\Property(property="surname",type="string", example="Doe"),
     *                     @OA\Property(property="subtitle", type="string", example="Engineer and Developer."),
     *                     @OA\Property(property="about", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
     *                     @OA\Property(property="cv", type="string", example="My currículum."),
     *                     @OA\Property(property="bootcamp", type="string", example="PHP Developer"),
     *                     @OA\Property(property="end_date", type="date", example="..." ),
     *                     @OA\Property(property="linkedin", type="string", example="http://www.linkedin.com"),
     *                     @OA\Property(property="github", type="string", example="http://www.github.com"),
     *                     @OA\Property(property="about", type="text", example="Todo sobre mi y muchas cosas más."),
     *                 )
     *             )
     *         )
     *     ),
     *
     *            @OA\Response(
     *            response=404,
     *            description="User not found."
     *     ),
     * )
     */
    public function show() {}
     
}