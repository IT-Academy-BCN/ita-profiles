<?php

declare(strict_types=1);

namespace Service\User;

use Illuminate\Http\JsonResponse;

trait registerMessage
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

    public function sendError($error, $errorMessages = [])
    {
        $response = [
            'success' => false, 
            'message' => $error, 
        ];
        // Verifica si hay mensajes de error adicionales y los incluye en la respuesta
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, 401);
    }
}