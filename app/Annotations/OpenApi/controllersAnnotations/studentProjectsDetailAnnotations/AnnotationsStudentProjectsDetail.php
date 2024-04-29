<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentProjectsDetailAnnotations;

use OpenApi\Annotations as OA;

class AnnotationsStudentProjectsDetail
{
   /**
 * @OA\Get(
 *      path="/students/{studentId}/projects",
 *      operationId="getStudentProjects",
 *      tags={"Projects"},
 *      summary="Get a detailed list of projects for a student",
 *      description="Returns a list of projects for a specific student.",
 *      @OA\Parameter(
 *          name="studentId",
 *          description="UUID of the student to get the projects",
 *          required=true,
 *          in="path",
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
 *                          property="uuid",
 *                          type="string",
 *                          format="uuid",
 *                          description="Unique identifier for the project",
 *                          example="9becbb14-0267-409b-9c77-9377ce67c9cf"
 *                      ),
 *                      @OA\Property(
 *                          property="project_name",
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
 *                              @OA\Property(property="id", type="integer", example=7),
 *                              @OA\Property(property="name", type="string", example="Bootstrap")
 *                          ),
 *                          description="List of tags associated with the project, each tag includes an id and a name"
 *                      ),
 *                      @OA\Property(
 *                          property="project_repository",
 *                          type="string",
 *                          description="URL of the project repository"
 *                      )
 *                  )
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Student,Projects or Resume not found",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  example="No s'ha trobat cap estudiant amb aquest ID {studentId}"
 *              ),
 *              @OA\Property(
 *                  property="message2",
 *                  type="string",
 *                  example="L'estudiant amb ID: {studentId} no té cap projecte informat al seu currículum"
 *              ),
 *              @OA\Property(
 *                  property="message3",
 *                  type="string",
 *                  example="No s'ha trobat cap currículum per a l'estudiant amb id: {studentId}"
 *              )
 *          )
 *      )
 * ),
 * @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Hi ha hagut un error")
 *         )
 *     ) 
 */

public function __invoke()
{
}

}
