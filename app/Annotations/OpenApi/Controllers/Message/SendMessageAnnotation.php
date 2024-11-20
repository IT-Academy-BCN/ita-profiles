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
     *     description="Stores a message in the database for communication between users.",
     *     security={{"passport": {}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new message",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="receiver", type="string", format="uuid", example="9d88709c-03b7-451f-8653-4da45a748ae9", description="UUID of the receiver user"),
     *             @OA\Property(property="subject", type="string", example="Hello!", description="The subject of the message"),
     *             @OA\Property(property="body", type="string", example="This is a test message.", description="The body of the message")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Message sent successfully", description="Success message"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000", description="UUID of the created message"),
     *                 @OA\Property(property="receiver", type="string", format="uuid", example="9d88709c-03b7-451f-8653-4da45a748ae9", description="UUID of the receiver user"),
     *                 @OA\Property(property="subject", type="string", example="Hello!", description="The subject of the message"),
     *                 @OA\Property(property="body", type="string", example="This is a test message.", description="The body of the message"),
     *                 @OA\Property(property="read", type="boolean", example=false, description="Indicates if the message has been read"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-13T12:34:56Z", description="Timestamp of when the message was created"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-13T12:34:56Z", description="Timestamp of when the message was last updated")
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=422,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation failed.", description="Validation failure message"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="receiver", type="array", @OA\Items(type="string", example="The receiver field is required.")),
     *                 @OA\Property(property="subject", type="array", @OA\Items(type="string", example="The subject field is required.")),
     *                 @OA\Property(property="body", type="array", @OA\Items(type="string", example="The body field is required."))
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.", description="Authentication failure message")
     *         )
     *     )
     * )
     */
    public function __invoke() {}
}
