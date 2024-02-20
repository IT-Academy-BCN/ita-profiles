<?php

namespace App\Annotations\OpenApi\controllersAnnotations\resumeAnnotations;

class AnnotationsResume
{
    /**
     * Create a new resume.
     *
     * @OA\Post(
     *     path="/resume",
     *     tags={"Resume"},
     *     summary="Create a new resume.",
     *     description="Creates a new resume for the authenticated student.",
     *     operationId="createResume",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a resume",
     *         @OA\JsonContent(
     *             required={"subtitle", "tags_ids", "specialization"},
     *             @OA\Property(property="subtitle", type="string", example="Fullstack PHP Developer"),
     *             @OA\Property(property="linkedin_url", type="string", format="uri", nullable=true, example="http://www.linkedin.com"),
     *             @OA\Property(property="github_url", type="string", format="uri", nullable=true, example="http://www.github.com"),
     *             @OA\Property(property="tags_ids", type="array", @OA\Items(type="string"), example={"tag1", "tag2"}),
     *             @OA\Property(property="specialization", type="string", enum={"Frontend", "Backend", "Fullstack", "Data Science", "Not Set"}, example="Fullstack")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resume created successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Resume created successfully."),
     *             @OA\Property(
     *                 property="resume",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", format="uuid", example="9b55d3f6-1184-4a70-8b3f-c14abf85e604"),
     *                 @OA\Property(property="subtitle", type="string", example="Fullstack PHP Developer"),
     *                 @OA\Property(property="linkedin_url", type="string", format="uri", nullable=true, example="http://www.linkedin.com"),
     *                 @OA\Property(property="github_url", type="string", format="uri", nullable=true, example="http://www.github.com"),
     *                 @OA\Property(property="tags_ids", type="array", @OA\Items(type="string"), example={"tag1", "tag2"}),
     *                 @OA\Property(property="specialization", type="string", enum={"Frontend", "Backend", "Fullstack", "Data Science", "Not Set"}, example="Fullstack")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User not authenticated."
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict. Duplicate resume found."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error. Failed to create resume."
     *     )
     * )
     */
    public function store()
    {
        // Method implementation
    }

    /**
     * Retrieve a specific resume.
     *
     * @OA\Get(
     *     path="/resume/{id}",
     *     tags={"Resume"},
     *     summary="Retrieve a specific resume.",
     *     description="Retrieve a specific resume by ID.",
     *     operationId="getResume",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the resume",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid", example="9b55d3f6-1184-4a70-8b3f-c14abf85e604")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns the specified resume.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", format="uuid", example="9b55d3f6-1184-4a70-8b3f-c14abf85e604"),
     *             @OA\Property(property="subtitle", type="string", example="Fullstack PHP Developer"),
     *             @OA\Property(property="linkedin_url", type="string", format="uri", nullable=true, example="http://www.linkedin.com"),
     *             @OA\Property(property="github_url", type="string", format="uri", nullable=true, example="http://www.github.com"),
     *             @OA\Property(property="tags_ids", type="array", @OA\Items(type="string"), example={"tag1", "tag2"}),
     *             @OA\Property(property="specialization", type="string", enum={"Frontend", "Backend", "Fullstack", "Data Science", "Not Set"}, example="Fullstack")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User not authenticated."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resume not found."
     *     )
     * )
     */
    public function show(string $id)
    {
        // Method implementation
    }

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
     *
     *          @OA\Schema(type="string"),
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="Data to be updated",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
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
     *
     *          @OA\JsonContent(
     *              type="object",
     *
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
    public function update()
    {
    }

    /**
     * @OA\Delete(
     *      path="/resume/{id}",
     *      operationId="deleteResume",
     *      tags={"Resume"},
     *      summary="Delete a resume",
     *      description="Delete an existing resume. Authentication and authorized ID are required.",
     *      security={{"bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the resume to be deleted",
     *          required=true,
     *
     *          @OA\Schema(type="string"),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success. Resume successfully deleted.",
     *      ),
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
    public function delete()
    {
    }
}
