<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class UpdateStudentProjectAnnotation
{
    /**
     * @OA\Put(
     *      path="/student/{student}/resume/projects/{project}",
     *      operationId="updateStudentProject",
     *      tags={"Student -> Resume"},
     *      summary="Update a project for a student",
     *      description="Updates the details of a specific project for a student.",
     *      security={
     *          {"bearerAuth": {}}
     *      },
     *      @OA\Parameter(
     *          name="student",
     *          in="path",
     *          description="Student ID",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="project",
     *          in="path",
     *          description="Project ID",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  description="Name of the project",
     *                  example="Updated Project Name"
     *              ),
     *              @OA\Property(
     *                  property="company_name",
     *                  type="string",
     *                  description="Name of the company associated with the project",
     *                  example="Updated Company Name"
     *              ),
     *              @OA\Property(
     *                 property="tags",
     *                 type="array",
     *                 description="Array of tag names. Pass the complete array of tag names to be associated with the project.",
     *                 example={"Web Development", "Laravel", "API"},
     *                 @OA\Items(
     *                     type="string",
     *                     description="Tag name"
     *                 )
     *              ),
     *              @OA\Property(
     *                  property="github_url",
     *                  type="string",
     *                  format="url",
     *                  description="URL of the project's GitHub repository",
     *                  example="https://github.com/updated-repo"
     *              ),
     *              @OA\Property(
     *                  property="project_url",
     *                  type="string",
     *                  format="url",
     *                  description="URL of the project",
     *                  example="https://updated-project.com"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="El projecte s'ha actualitzat"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Student or Project not found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No query results for model [App\\Models\\Student] invalid_student_id']"
     *              ),
     *              @OA\Property(
     *                  property="message2",
     *                  type="string",
     *                  example="No query results for model [App\\Models\\Project] invalid_project_id'"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="This action is unauthorized."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Hi ha hagut un error"
     *              )
     *          )
     *      )
     * )
     */
    public function __invoke() {}
}
