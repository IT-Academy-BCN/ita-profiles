<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Mesagge;

use app\Models\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use DragonCode\PrettyArray\Services\Formatters\Json;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class SendMessageController extends Controller
{
    public function __invoke(SendMessageRequest $request, User $receiver):JsonResponse
    {
        $data = $request->validated();

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $receiver->id,
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        return response()->json([
            'data' => $message,
            'message' => 'Message sent successfully',
        ], 200);

    }
}
