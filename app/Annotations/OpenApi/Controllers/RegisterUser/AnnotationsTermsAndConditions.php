<?php

namespace App\Annotations\OpenApi\controllersAnnotations\registerUserAnnotations;

class AnnotationsTermsAndConditions
{   
    /**
     * @OA\Get(
     *     path="/terms-and-conditions",
     *     tags={"Terms and Conditions"},
     *     summary="Get terms and conditions",
     *     description="Get register terms and conditions .",
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Términos y condiciones obtenidos correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 description="El contenido de los términos y condiciones"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Mensaje de error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Detalles del error"
     *             )
     *         )
     *     )
     * )
     */


    public function __invoke() {}
}