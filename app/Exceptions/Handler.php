<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Manejo de excepciones para modelos no encontrados
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                $model = $e->getModel();
                return response()->json([
                    'message' => $model ? "{$model} not found" : 'Resource not found',
                ], 404);
            }
            Log::error('Model not found', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        // Manejo de excepciones de validación (422)
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
            Log::error('Validation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        // Manejo de excepciones generales
        $this->renderable(function (Exception $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
            Log::error('Server error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        // Manejo de excepciones HTTP
        $this->reportable(function (HttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }
            Log::error('Http error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        // Manejo de excepciones de autorización (403)
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'This action is unauthorized.',
                ], 403);
            }
            Log::error('Authorization error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        });
    }
}
