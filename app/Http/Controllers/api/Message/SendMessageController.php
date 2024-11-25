<?php

namespace App\Http\Controllers\api\Message;

use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SendMessageController extends Controller
{
    public function __invoke(StoreMessageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['sender_id'] = Auth::id();

        Message::create($data);

        return response()->json([
            'message' => 'Message sent successfully'
        ], 201);

    }
}
