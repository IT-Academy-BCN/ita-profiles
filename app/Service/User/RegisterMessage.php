<?php

declare(strict_types=1);

namespace Service\User;

use Illuminate\Http\JsonResponse;

trait RegisterMessage
{
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = []):JsonResponse
    {
        $response = [
            'success' => false, 
            'message' => $error, 
        ];
        // Checks for additional error messages and includes them in the response
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, 401);
    }
}
