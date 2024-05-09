<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentResumeAnnotations;

class AnnotationsStudentList
{
    /**
     * @OA\Get(
     *     path="/student/resume/list",
     *     operationId="getListStudents",
     *     tags={"Student -> Resume"},
     *     summary="Get Students List.",
     *
     *     description="Get a list of all students registered with the Profile-Home fields in Figma Design.

- If a 'specialization' parameter is provided, the list will be filtered by student's specialization.

- If not, it returns a list of all students.

- Multiple parameters can be added separated by commas without spaces.

- For example, if the objetive is to filter Backend and Frontend students, the query would be:

    ```/student/resume/list?specialization=frontend,backend```
    - To filter by tags, the query would be:
    ```/student/resume/list?tags=PHP,Laravel```
    - To filter by both specialization and tags:
    ```/student/resume/list?specialization=frontend&tags=php,react```

---

    No authentication required",
     *
     *     @OA\Parameter(
     *       name="specialization",
     *       in="query",
     *       description="The specializations to filter students by",
     *       required=false,
     *       style="form",
     *       explode=true,
     *
     *       @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *       name="tags",
     *       in="query",
     *       description="The tags to filter students by",
     *       required=false,
     *       style="form",
     *       explode=true,
     *       @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="A list of students",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                    property="id",
     *                    type="string",
     *                    example="9bc3c8fd-7754-43e0-95a1-68fc011d106c"),
     *                 @OA\Property(
     *                    property="fullname",
     *                    type="string",
     *                    example="Juan Pérez"),
     *                 @OA\Property(
     *                    property="subtitle",
     *                    type="string",
     *                    example="Desarrollador Frontend"),
     *                 @OA\Property(
     *                    property="photo",
     *                    description="Student Image Path",
     *                     type="string",
     *                     example="https://itaperfils.eurecatacademy.org/img/stud_1.png"),
     *                 @OA\Property(
     *                   property="tags",
     *                   type="array",
     *
     *                   @OA\Items(
     *                     type="object",
     *
     *                     @OA\Property(property="id", type="integer", example=15),
     *                     @OA\Property(property="name", type="string", example="C#"),
     *                     example={"id": 15, "name": "C#"}
     *                   ),
     *                 )
     *             )
     *          )
     *      ),
     * )
     */
    public function __invoke() {}
}
