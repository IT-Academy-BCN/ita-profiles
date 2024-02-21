<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentAnnotations;

class AnnotationsStudent
{
    /**
     * @OA\Get(
     *     path="/student/list/for-home",
     *     operationId="getAllStudentsForFigma",
     *     tags={"Student"},
     *     summary="Get all Students.",
     *     description="Get a list of all students registered with the Profile-Home fields in Figma Design.

    No authentication required",
     *
     *     @OA\Response(
     *         response=200,
     *         description="",
     *
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="fullname", type="string", example="Juan Pérez"),
     *                     @OA\Property(property="subtitle", type="string", example="Desarrollador Frontend"),
     *                     @OA\Property(property="photo",description="Student Image Path",
     *                              type="string",
     *                              example="img/stud_1.png"),
     *                     @OA\Property(property="tags",type="array",@OA\Items(ref="#/components/schemas/Tag"))
     *
     *                  )
     *              )
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

    /** List all students (INDEX)
     *
     * @OA\Get (
     *     path="/students",
     *     operationId="getStudents",
     *     tags={"Student"},
     *     summary="Get list of students.",
     *     description="Retrieves a paginated list of students.

    No authentication required",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns a list of students.",
     *
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(ref="#/components/schemas/Student")
     *             ),
     *                 @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                   property="first",
     *                   type="string",
     *                   example="http://127.0.0.1:8000/api/v1/students?page=1"),
     *                 @OA\Property(
     *                   property="last",
     *                   type="string",
     *                   example="http://127.0.0.1:8000/api/v1/students?page=1"),
     *                 @OA\Property(property="prev", type="string", example=null),
     *                 @OA\Property(property="next", type="string", example=null)
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", example=null),
     *                         @OA\Property(property="label", type="string", example="&laquo; Anterior"),
     *                         @OA\Property(property="active", type="boolean", example=false)
     *                     )
     *                 ),
     *                 @OA\Property(property="path", type="string", example="http://127.0.0.1:8000/api/v1/students"),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="to", type="integer", example=2),
     *                 @OA\Property(property="total", type="integer", example=2)
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="Student",
     *     type="object",
     *       @OA\Property(property="name", type="string", example="John"),
     *       @OA\Property(property="surname", type="string", example="Doe"),
     *       @OA\Property(property="photo", type="string", example="http://www.photo.com/johndoe"),
     *       @OA\Property(property="status", type="enum", example="active"),
     *       @OA\Property(
     *           property="id",
     *           type="uuid",
     *           description="UUID of the student",
     *           example="9b60ef21-ff25-44d5-ba26-217b9b816192"),
     * )
     */
    public function index() {}

    /** Create a student (STORE)
     *
     * @OA\Post (
     *     path="/students",
     *     operationId="createStudent",
     *     tags={"Student"},
     *     summary="Create a new Student.",
     *     description="Creates a new student with the provided data.
          <ul><li>Name and Surname are <b>required</b>.</li>
          <li><b>Status</b> can be <i>'Active'</i>, <i>'Inactive'</i>, <i>'In a Bootcamp'</i> or <i>'In a Job'.</i></li>
          <li><b>Active</b> status is set by <b>default</b>.</li>
          <li>Authentication is not required.</li></ul>",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for the new student",
     *         @OA\JsonContent(
     *           required={"name", "surname", "status"},
     *           @OA\Property(
     *             property="name",
     *             type="string",
     *             description="First name of the student",
     *             example="Name"),
     *           @OA\Property(
     *             property="surname",
     *             type="string",
     *             description="Surname of the student",
     *             example="Surname"),
     *           @OA\Property(
     *             property="photo",
     *             type="string",
     *             description="URL to the photo of the student",
     *             example="http://www.photo.com"),
     *           @OA\Property(
     *             property="status",
     *             type="string",
     *             description="Status of the student",
     *             example="Active"),
     *             enum={"Active", "Inactive", "In a Bootcamp", "In a Job"},
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Student created successfully. No token is returned.",
     *
     *         @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Success message",
     *                  example="Registre realitzat amb èxit."),
     *                  @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Student"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request when data validation fails",
     *         @OA\JsonContent(
     *             @OA\Property(
     *               property="message",
     *               type="string",
     *               description="Error message",
     *               example="Registre no efectuat. Si-us-plau, torna-ho a provar."),
     *             @OA\Property(property="error", type="string", description="Error details")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Detail of validation errors")
     *         )
     *     )
     * )
     */
    public function store() {}

    /** Show details from one student (SHOW)
     *
     * @OA\Get (
     *     path="/students/{id}",
     *     operationId="getStudentDetails",
     *     tags={"Student"},
     *     summary="Get details of a Student.",
     *     description="Get the details of a specific student by UUID.

    No authentication required",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="UUID of the student",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string",
     *              format="uuid",
     *              example="123e4567-e89b-12d3-a456-426614174000"
     *          ),
     *      ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="Success. Returns student details.",
     *
     *         @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Success message",
     *                  example="Registre realitzat amb èxit."),
     *                  @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Student"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Student not found."
     *     ),
     * )
     */
    public function show() {}

    /** Update Student details (UPDATE)
     *
     * @OA\Put(
     *    path="/students/{id}",
     *    operationId="updateStudent",
     *    tags={"Student"},
     *    summary="Update a Student.",
     *    description="Update the details of a specific Student.
          <ul><li>Name and Surname are <b>required</b>.</li>
          <li><b>Status</b> can be <i>'Active'</i>, <i>'Inactive'</i>, <i>'In a Bootcamp'</i> or <i>'In a Job'.</i></li>
          <li><b>Active</b> status is set by <b>default</b>.</li>
          <li>Authentication is not required.</li></ul>",
     *
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="UUID of the Student to be updated.",
     *
     *          @OA\Schema(
     *              type="string",
     *              format="uuid",
     *              example="9b60ef21-ff25-44d5-ba26-217b9b816192"
     *          )
     *      ),
     *
     *    @OA\RequestBody(
     *        required=true,
     *        description="New data to update the student with that UUID.",
     *        @OA\JsonContent(
     *            type="object",
     *            required={"name", "surname", "status"},
     *        @OA\Property(
     *           property="name",
     *           type="string",
     *           description="First name of the student",
     *           example="NewName"),
     *        @OA\Property(
     *           property="surname",
     *           type="string",
     *           description="Surname of the student",
     *           example="NewSurname"),
     *        @OA\Property(
     *           property="photo",
     *           type="string",
     *           description="URL to the photo of the student",
     *           example="http://www.photo.com/new"),
     *        @OA\Property(
     *           property="status",
     *           type="string",
     *           description="Status of the student",
     *           example="Inactive",
     *           enum={"Active", "Inactive", "In a Bootcamp", "In a Job"}),
     *        ),
     *    ),
     *        @OA\Response(
     *          response=200,
     *          description="Success. Returns Student details.",
     *          @OA\JsonContent(ref="#/components/schemas/Student")
     *       ),
     *         @OA\Response(
     *         response=400,
     *         description="Bad request",
     *       ),
     *         @OA\Response(
     *         response=404,
     *         description="Student not found",
     *            @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Something went wrong. Try it again later.")
     *       ),
     *    )
     * )
     */
    public function update() {}

    /** Delete a Student (DESTROY)
     * @OA\Delete(
     *      path="/students/{id}",
     *      operationId="deleteStudent",
     *      tags={"Student"},
     *      summary="Delete a Student.",
     *      description="Delete a specific Student by his UUID.

    No authentication required",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="UUID of the Student to be deleted",
     *          required=true,
     *
     *           @OA\Schema(
     *              type="string",
     *              format="uuid",
     *              example="9b60ef21-ff25-44d5-ba26-217b9b816192"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=204,
     *          description="No Content. Student deleted successfully",
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Student not found",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Student not found")
     *          )
     *      )
     * )
     */
    public function destroy() {}
}
