<?php

namespace App\Annotations\OpenApi\controllersAnnotations\resumeAnnotations;

class AnnotationsResume
{
    /**
    * @OA\Put(
    *      path="/resume/{id}",
    *      operationId="updateResume",
    *      tags={"Resume"},
    *      summary="Update a resume",
    *      description="Update an existing resume. Authentication is required.",
    *      security={{"bearerAuth": {}}},
    *
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          description="ID of the resume to be updated",
    *          required=true,
    *          @OA\Schema(type="string"),
    *      ),
    *
    *      @OA\RequestBody(
    *          required=true,
    *          description="Data to be updated",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="subtitle", type="string", example="New Subtitle"),
    *              @OA\Property(property="linkedin_url", type="string", format="url", example="https://www.linkedin.com"),
    *              @OA\Property(property="github_url", type="string", format="url", example="https://www.github.com"),
    *              @OA\Property(property="specialization", type="enum", enum={"Frontend", "Backend", "Fullstack", "Data Science", "Not Set"}, example="Backend"),
    *          )
    *      ),
    *
    *      @OA\Response(
    *          response=200,
    *          description="Success. Returns updated resume details.",
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="subtitle", type="string", example="New Subtitle"),
    *              @OA\Property(property="linkedin_url", type="string", format="url", example="https://www.linkedin.com"),
    *              @OA\Property(property="github_url", type="string", format="url", example="https://www.github.com"),
    *              @OA\Property(property="specialization", type="enum", enum={"Frontend", "Backend", "Fullstack", "Data Science", "Not Set"}, example="Backend"),
    *          )
    *      ),
    *
    *      @OA\Response(
    *          response=401,
    *          description="You do not have permission to modify this resume"
    *      ),
    *      @OA\Response(
    *          response=404,
    *          description="Not Found. Resume with specified ID not found."
    *      ),
    * )
    */

    public function update() {}

    /**
 * @OA\Delete(
 *      path="/resume/{id}",
 *      operationId="deleteResume",
 *      tags={"Resume"},
 *      summary="Delete a resume",
 *      description="Delete an existing resume. Authentication and authorized ID are required.",
 *      security={{"bearerAuth": {}}},
 *
 *
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID of the resume to be deleted",
 *          required=true,
 *          @OA\Schema(type="string"),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success. Resume successfully deleted.",
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized. Authentication failed or token is missing or invalid."
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not Found. Resume with specified ID not found."
 *      ),
 * )
 */


    public function delete() {}
}
