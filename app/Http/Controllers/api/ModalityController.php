<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\Student\ModalityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ModalityController extends Controller
{
    private ModalityService $modalityService;

    public function __construct(ModalityService $modalityService)
    {
        $this->modalityService = $modalityService;
    }

    public function __invoke($studentId): JsonResponse
    {
        try {
            $service = $this->modalityService->execute($studentId);
            return response()->json(['modality'=>$service]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No se encontrado ningún currículum para el estudiante ' . $studentId], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}