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
     *     summary="Send a new message.",
     *     description="Sends a new message to a specified receiver with a subject and body.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message details to send.

- `receiver` is **required** and must be a **UUID** of an existing user.
- `subject` is **required**, must be a **string**, and **less than 255 characters**.
- `body` is **required** and must be a **string**.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="receiver", type="string", format="uuid", example="9d88709c-03b7-451f-8653-4da45a748ae9"),
     *             @OA\Property(property="subject", type="string", example="Hello!"),
     *             @OA\Property(property="body", type="string", example="This is a test message."),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Message sent successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="receiver", type="string", format="uuid", example="9d88709c-03b7-451f-8653-4da45a748ae9"),
     *                 @OA\Property(property="subject", type="string", example="Hello!"),
     *                 @OA\Property(property="body", type="string", example="This is a test message."),
     *                 @OA\Property(property="read", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-11-14T10:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-11-14T10:30:00Z"),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="receiver", type="array",
     *                     @OA\Items(type="string", example="The receiver must be a valid UUID.")
     *                 ),
     *                 @OA\Property(property="subject", type="array",
     *                     @OA\Items(type="string", example="The subject field is required.")
     *                 ),
     *                 @OA\Property(property="body", type="array",
     *                     @OA\Items(type="string", example="The body field is required.")
     *                 ),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         ),
     *     ),
     * )
     */
    public function __invoke() {}
}
