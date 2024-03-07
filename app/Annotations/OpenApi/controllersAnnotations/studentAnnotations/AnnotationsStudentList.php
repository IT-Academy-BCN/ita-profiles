<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentAnnotations;

class AnnotationsStudentList
{
    /**
     * @OA\Get(
     *     path="/student/list/for-home",
     *     operationId="getAllStudentsForFigma",
     *     tags={"Student"},
     *     summary="Get Students List.",
     *
     *     description="Get a list of all students registered with the Profile-Home fields in Figma Design. If a 'specialization' parameter is provided, the list will be filtered by this specialization. If no parameter is provided, it returns a list of all students.

     No authentication required",
     *
     *     @OA\Parameter(
     *       name="specialization",
     *       in="query",
     *       description="The specialization to filter students by",
     *       required=false,
     *       @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of students",
     *
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="fullname", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="subtitle", type="string", example="Desarrollador Frontend"),
     *                 @OA\Property(property="photo",description="Student Image Path",
     *                     type="string",
     *                     example="https://itaperfils.eurecatacademy.org/img/stud_1.png"),
     *                 @OA\Property(
     *                   property="tags",
     *                   type="array",
     *                   @OA\Items(ref="#/components/schemas/Tag"))
     *             )
     *          )
     *      ),
     *
     *      @OA\Schema(
     *           schema="Tag",
     *           type="object",
     *           @OA\Property(property="id", type="integer", example=1),
     *           @OA\Property(property="name", type="string", example="JavaScript"),
     *           example={"id": 1, "name": "JavaScript"}
     *      )
     * )
     */
    public function __invoke() {}
}
