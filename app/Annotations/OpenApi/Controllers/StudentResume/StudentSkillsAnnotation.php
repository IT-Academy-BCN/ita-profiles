<?php

namespace App\Annotations\OpenApi\Controllers\StudentResume;

class StudentSkillsAnnotation
{
    /**
     * @OA\Put (
     *     path="/student/{studentId}/resume/skills",
     *     operationId="updateSkillsByStudentId",
     *     tags={"Student -> Resume"},
     *     summary="Update Student Skills.",
     *     description="Retrieve details of a specific student. No authentication required.",
     * 
     *      
     *     @OA\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="Student ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     * 
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="skills", type="array", 
     * 
     *              @OA\Items(
     *                 type="string",
     *                 example="react"
     *             ),
     *              example={"react", "php", "html", "css", "tailwind"}),
     *          )
     *      ),
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the skills.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *             type="object",
     * 
     *             @OA\Property(
     *                 property="skills",
     *                 type="string",
     *                 example="php:react:javascript:node:html5",
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="succes/failure",
     *             )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hem trobat cap estudiant amb aquest ID"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function __invoke() {}
}
