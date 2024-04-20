<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\Student\ModalityService;
use App\Exceptions\ModalityNotFoundException;
use App\Exceptions\StudentNotFoundException;
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
            return response()->json(['modality' => $service]);
        } catch (StudentNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (ModalityNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}