<?php

namespace App\Annotations\OpenApi\controllersAnnotations\studentAnnotations;

class AnnotationsStudentDetail
{
    /**
     * @OA\Get(
     *     path="/student/{student}/detail/for-home",
     *     operationId="getStudentDetail",
     *     tags={"Student"},
     *     summary="Get Student Detail.",
     *     description="Get student detail registered. No authentication required",
     *
     *     @OA\Response(
     *         response=200,
     *         description="",
     *
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="student_id", type="integer", example=1),
     *                     @OA\Property(
     *                         property="profile_detail",
     *                         type="object",
     *                         @OA\Property(property="fullname", type="string", example="Juan Pérez"),
     *                         @OA\Property(property="subtitle", type="string", example="Desarrollador Frontend"),
     *                         @OA\Property(
     *                             property="social_media",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="linkedin",
     *                                 type="object",
     *                                 @OA\Property(property="url", type="string", example="https://es.linkedin.com/"),
     *                             ),
     *                             @OA\Property(
     *                                 property="github",
     *                                 type="object",
     *                                 @OA\Property(property="url", type="string", example="https://github.com/"),
     *                             )
     *                         ),
     *                         @OA\Property(
     *                             property="about",
     *                             type="object",
     *                             @OA\Property(property="description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a euismod elit. Nunc elit ante, vulputate sed maximus eu, posuere eu nibh. In eget lacus in mi pharetra volutpat a a justo. Fusce aliquet nibh nec accumsan facilisis. Suspendisse in tempor nibh, eu fermentum velit. Suspendisse cursus ultricies ipsum, eget tincidunt arcu pretium laoreet. Pellentesque eget egestas erat. Donec dapibus pharetra ultrices. Vivamus mollis sapien sed laoreet interdum."
     *                              )
     *                          ),
     *                             @OA\Property(property="tags",type="array",@OA\Items(ref="#/components/schemas/Tag"))
     *                         )
     *
     *                  )
     *              )
     *          )
     *      ),
     *
     *
     *      @OA\Schema(
     *           schema="Tag",
     *           type="object",
     *           @OA\Property(property="id", type="integer", example=1),
     *           @OA\Property(property="name", type="string", example="JavaScript"),
     *           example={"id": 1, "name": "JavaScript"}
     *      )
     * )
     */
    public function __invoke() {}
}
