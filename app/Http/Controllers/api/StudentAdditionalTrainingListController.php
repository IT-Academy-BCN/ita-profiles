<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\StudentAdditionalTrainingService;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentAdditionalTrainingListController extends Controller
{
    protected StudentAdditionalTrainingService $studentAdditionalTrainingService;

    public function __construct(StudentAdditionalTrainingService $studentAdditionalTrainingService)
    {
        $this->studentAdditionalTrainingService = $studentAdditionalTrainingService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $additionalTrainings = $this->studentAdditionalTrainingService->execute($studentId);
            return response()->json(['additional_trainings' => $additionalTrainings]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
