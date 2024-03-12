<?php 
namespace App\Annotations\OpenApi\controllersAnnotations\additionalTrainingAnnotations;

class AnnotationsAdditionalTraining
{
/**
 * @OA\Get(
 *     path="/additional-training/list",
 *     summary="Retrieve a list of additional training",
 *     tags={"Additional Training"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful. Additional training list retrieved",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="course", type="string"),
 *                 @OA\Property(property="center", type="string"),
 *                 @OA\Property(property="year", type="string"),
 *                 @OA\Property(property="duration", type="integer"),
 *             )
 *         )
 *     )
 * )
 */

    public function __invoke(){}
}