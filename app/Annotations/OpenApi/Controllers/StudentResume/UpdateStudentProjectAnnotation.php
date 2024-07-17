<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class UpdateStudentProjectAnnotation
{
 /**
   * @OA\Put(
   *      path="/student/{studentId}/resume/projects/{projectId}",
   *      operationId="updateStudentProject",
   *      tags={"Student -> Resume"},
   *      summary="Update a project for a student",
   *      description="Updates the details of a specific project for a student.",
   *      @OA\Parameter(
   *          name="studentId",
   *          in="path",
   *          description="Student ID",
   *          required=true,
   *          @OA\Schema(
   *              type="string",
   *              format="uuid"
   *          )
   *      ),
   *      @OA\Parameter(
   *          name="projectId",
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
   *                  property="project_name",
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
   *                  property="tags",
   *                  type="array",
   *                  @OA\Items(
   *                      type="string",
   *                      example="Updated Tag"
   *                  ),
   *                  description="List of tags associated with the project"
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
   *                  example="No s'ha trobat cap estudiant amb aquest ID {studentId}"
   *              ),
   *              @OA\Property(
   *                  property="message2",
   *                  type="string",
   *                  example="No s'ha trobat cap projecte amb aquest ID {projectId}"
   *              )
   *          )
   *      ),
   *     
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
  public function __invoke()
  {
  }
}
