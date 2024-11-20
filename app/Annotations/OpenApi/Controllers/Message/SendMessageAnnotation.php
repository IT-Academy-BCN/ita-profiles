<?php

declare(strict_types=1);

namespace App\Annotations\OpenApi\Controllers\Message;

class SendMessageAnnotation
{
    /**
     * @OA\Post(
     *     path="/messages",
     *     operationId="sendMessage",
     *     tags={"Messages"},
     *     summary="Send a new message to a user.",
     *     description="Stores a message in the database.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="receiver", type="string", example="9d88709c-03b7-451f-8653-4da45a748ae9"),
     *             @OA\Property(property="subject", type="string", example="Hello!"),
     *             @OA\Property(property="body", type="string", example="This is a test message.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Message sent successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="receiver", type="string", example="9d88709c-03b7-451f-8653-4da45a748ae9"),
     *                 @OA\Property(property="subject", type="string", example="Hello!"),
     *                 @OA\Property(property="body", type="string", example="This is a test message.")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation failed."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="receiver", type="array", @OA\Items(type="string", example="The receiver field is required."))
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
