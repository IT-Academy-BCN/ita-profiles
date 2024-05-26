<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\StudentAdditionalTrainingListService;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentAdditionalTrainingListController extends Controller
{
    protected StudentAdditionalTrainingListService $studentAdditionalTrainingListService;

    public function __construct(StudentAdditionalTrainingListService $studentAdditionalTrainingListService)
    {
        $this->studentAdditionalTrainingListService = $studentAdditionalTrainingListService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $additionalTrainings = $this->studentAdditionalTrainingListService->execute($studentId);
            return response()->json(['additional_trainings' => $additionalTrainings]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
