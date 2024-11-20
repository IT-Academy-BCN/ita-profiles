<?php

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

        $sender = Auth::id();

        $message = Message::create($request->validated());

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 200);

    }
}
