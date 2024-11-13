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
    public function __invoke(SendMessageRequest $request, int $receiver_id): JsonResponse
    {
        // Get the authenticated user as the sender
        $sender = Auth::user();

        // Find the receiver
        $receiver = User::find($receiver_id);

        if (!$receiver) {
            return response()->json(['error' => 'Receiver not found'], 404);
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
        ]);
    }
}
