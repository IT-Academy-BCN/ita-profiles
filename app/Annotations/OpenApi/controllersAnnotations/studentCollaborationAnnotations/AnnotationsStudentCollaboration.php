<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentCollaborationAnnotations;

class AnnotationsStudentCollaboration
{
/**
 * @OA\Get(
 *     path="/students/{uuid}/collaborations",
 *     operationId="getStudentCollaborations",
 *     summary="Retrieve a list of collaborations",
 *     tags={"Collaboration"},
 *
 *
 *          @OA\Parameter(
 *          name="uuid",
 *          description="Student UUID",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              format="uuid"
 *          )
 *      ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful. Collaboration list retrieved",
 *         @OA\JsonContent(
 *             type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="uuid", type="string", format="uuid"),
 *                     @OA\Property(property="collaboration_name", type="string"),
 *                     @OA\Property(property="collaboration_description", type="text"),
 *                     @OA\Property(property="collaboration_quantity", type="integer"),
 *                 )
 *             )
 *         )
 *     )
 * )
 */

    public function __invoke(){}
}
