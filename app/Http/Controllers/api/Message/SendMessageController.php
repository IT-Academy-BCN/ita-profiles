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
    public function __invoke(SendMessageRequest $request): JsonResponse
    {
        // Get the receiver from the request (already validated and resolved)
        $receiver = $request->getReceiver();

        $message = Message::create([
            'sender_id' => $sender->id,
            'sender_type' =>get_class($sender),
            'receiver_id' => $receiver->id,
            'receiver_type' => get_class($receiver),
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'date' => $message,
        ], 200);

    }
}
