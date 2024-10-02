<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

use OpenApi\Annotations as OA;

class StudentProjectsDetailAnnotation
{
  /**
   * @OA\Get(
   *      path="/student/{student}/resume/projects",
   *      operationId="getStudentResumeProjects",
   *      tags={"Student -> Resume"},
   *      summary="Get a detailed list of projects for a student",
   *      description="Retrieves a detailed list of projects for a specific student from it's resume.",
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
   *      @OA\Response(
   *          response=200,
   *          description="Successful operation",
   *          @OA\JsonContent(
   *              type="object",
   *              @OA\Property(
   *                  property="projects",
   *                  type="array",
   *                  @OA\Items(
   *                      type="object",
   *                      @OA\Property(
   *                          property="id",
   *                          type="string",
   *                          format="uuid",
   *                          description="Unique identifier for the project",
   *                          example="9becbb14-0267-409b-9c77-9377ce67c9cf"
   *                      ),
   *                      @OA\Property(
   *                          property="name",
   *                          type="string",
   *                          description="Name of the project",
   *                          example="ITA Profiles"
   *                      ),
   *                      @OA\Property(
   *                          property="company_name",
   *                          type="string",
   *                          description="Name of the company associated with the project",
   *                          example="Barcelona Activa"
   *                      ),
   *                      @OA\Property(
   *                          property="github_url",
   *                          type="string",
   *                          description="URL of github repository of the project",
   *                          example="https://www.github.com/user/ita-profiles"
   *                      ),
   *                      @OA\Property(
   *                          property="project_url",
   *                          type="string",
   *                          description="URL of the project",
   *                          example="https://www.ita-profiles.com"
   *                      ),
   *                      @OA\Property(
   *                          property="tags",
   *                          type="array",
   *                          @OA\Items(
   *                              type="object",
   *                              @OA\Property(
   *                                  property="id",
   *                                  type="integer",
   *                                  description="Tag ID",
   *                                  example=10
   *                              ),
   *                              @OA\Property(
   *                                  property="name",
   *                                  type="string",
   *                                  description="Name of the tag",
   *                                  example="Bootstrap"
   *                              )
   *                          ),
   *                          description="List of tags associated with the project, each tag includes an id and a name"
   *                      )
   *                  )
   *              )
   *          )
   *      ),
   *      @OA\Response(
   *          response=404,
   *          description="Student not found",
   *          @OA\JsonContent(
   *              @OA\Property(
   *                  property="message",
   *                  type="string",
   *                  example="No query results for model [App\\Models\\Student] {studentId}"
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
   *                  example="Server Error"
   *              )
   *          )
   *      )
   * )
   */

  public function __invoke() {}
}
