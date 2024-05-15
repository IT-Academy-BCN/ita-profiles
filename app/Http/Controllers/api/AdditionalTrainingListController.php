<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\AdditionalTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class AdditionalTrainingListController extends Controller
{
    protected AdditionalTrainingService $additionalTrainingService;

    public function __construct(AdditionalTrainingService $additionalTrainingService)
    {
        $this->additionalTrainingService = $additionalTrainingService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $additionalTrainings = $this->additionalTrainingService->execute($studentId);
            return response()->json(['additional_trainings' => $additionalTrainings]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
