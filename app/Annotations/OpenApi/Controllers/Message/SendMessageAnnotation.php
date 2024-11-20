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
     *     description="Stores a message in the database. This endpoint requires a Bearer token for authentication.",
     *
     *     security={
     *         {"passport": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="receiver", type="string", example="9d88709c-03b7-451f-8653-4da45a748ae9", description="The UUID of the user receiving the message"),
     *             @OA\Property(property="subject", type="string", example="Hello!", description="The subject of the message"),
     *             @OA\Property(property="body", type="string", example="This is a test message.", description="The body content of the message")
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
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
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
     *                 @OA\Property(property="receiver", type="array", @OA\Items(type="string", example="The receiver field is required.")),
     *                 @OA\Property(property="subject", type="array", @OA\Items(type="string", example="The subject field is required.")),
     *                 @OA\Property(property="body", type="array", @OA\Items(type="string", example="The body field is required."))
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
