<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Message;

use app\Models\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class SendMessageController extends Controller
{
    public function __invoke(SendMessageRequest $request, $receiver): JsonResponse
    {
        $data = $request->validated();

        // Assuming the authenticated user is the sender
        $sender = $request->user(); // Could be User, Admin, etc.

        $message = Message::create([
            'sender_id' => $sender->id,
            'sender_type' => get_class($sender),
            'receiver_id' => $receiver->id,
            'receiver_type' => get_class($receiver),
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }
}
