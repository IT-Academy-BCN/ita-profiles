<?php 
declare(strict_types=1);

namespace Service\User;

Trait registerMessage
{
    public function sendResponse($result, $message)
    {
        // Crea un arreglo con los datos de la respuesta exitosa
        $response = [
            'success' => true, // Indica que la respuesta fue exitosa
            'data' => $result, // Incluye los datos de la respuesta
            'message' => $message, // Incluye un mensaje descriptivo
        ];
        // Retorna una respuesta en formato JSON con código de estado 200 (éxito)
        return response()->json($response, 200);
    }

}