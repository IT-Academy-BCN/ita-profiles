<?php

namespace App\Annotations\OpenApi\controllersAnnotations\resumeTagAnnotations;

class AnnotationResumeTag
{
    /**
     * @OA\Post(
     *     path="/resume/tags/assign",
     *     tags={"ResumeTag"},
     *     summary="Assign tags to a resume",
     *     description="Assigns tags to a specific resume by a student.",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"tag_ids"},
     *
     *             @OA\Property(
     *                 property="tags_ids",
     *                 type="array",
     *                 description="Array of tag IDs",
     *
     *                 @OA\Items(type="string", example=1),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tags assigned successfully to the resume",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request: No tags provided or request format is incorrect",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity: All provided tags already exist in the resume",
     *     ),
     * )
     */
    public function store()
    {

    }

    /**
     * Remove specified tags from the resume.
     *
     * @OA\Delete(
     *     path="/resume/tags/remove",
     *     tags={"ResumeTag"},
     *     summary="Remove specified tags from the resume",
     *     description="Remove specified tags from the resume of the authenticated student.",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"tags_ids"},
     *
     *             @OA\Property(
     *                 property="tags_ids",
     *                 type="array",
     *                 description="Array of tag IDs to be removed",
     *
     *                 @OA\Items(type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tags removed successfully from the resume",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request: No tag IDs provided",
     *     ),
     * )
     */
    public function destroy()
    {

    }
}
