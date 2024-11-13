<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Message;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;

class SendMessageController extends Controller
{
    public function __invoke(SendMessageRequest $request, string $type, int $id): JsonResponse
    {
        // Map the `type` string to the appropriate model class
        $modelMap = [
            'user' => \App\Models\User::class,
            'student' => \App\Models\Student::class,
            'recruiter' => \App\Models\Recruiter::class,
            'admin' => \App\Models\Admin::class,
        ];

        // Check if the type is valid, and get the model class
        if (!array_key_exists($type, $modelMap)) {
            return response()->json(['error' => 'Invalid receiver type'], 400);
        }

        // Retrieve the receiver model instance
        $receiverModel = $modelMap[$type];
        $receiver = $receiverModel::find($id);

        if (!$receiver) {
            return response()->json(['error' => 'Receiver not found'], 404);
        }

        // Assume the authenticated user is the sender
        $sender = $request->user(); // or get sender via another mechanism

        // Create the message
        $message = Message::create([
            'sender_id' => $sender->id,
            'sender_type' => get_class($sender),
            'receiver_id' => $receiver->id,
            'receiver_type' => get_class($receiver),
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }
}