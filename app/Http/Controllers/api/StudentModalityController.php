<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\StudentModalityService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentModalityController extends Controller
{
    private StudentModalityService $studentModalityService;

    public function __construct(StudentModalityService $studentModalityService)
    {
        $this->studentModalityService = $studentModalityService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->studentModalityService->execute($studentId);
            return response()->json(['modality' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}