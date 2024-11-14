<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Message;

use App\Models\Message;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SendMessageController extends Controller
{
    public function __invoke(SendMessageRequest $request, int $id): JsonResponse
    {
        // Find the receiver by ID
        $receiver = User::find($id);

        if (!$receiver) {
            // Return 404 if receiver not found
            return response()->json(['error' => 'Receiver not found'], 404);
        }

        // Get the authenticated user as the sender
        $sender = Auth::user();
        if (!$sender) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Create the message
        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 200);
    }
}
