<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\StudentBootcampDetailService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentBootcampDetailController extends Controller
{
    private StudentBootcampDetailService $studentBootcampDetailService;

    public function __construct(StudentBootcampDetailService $studentBootcampDetailService)
    {
        $this->studentBootcampDetailService = $studentBootcampDetailService;
    }
    public function __invoke($studentId): JsonResponse
    {
        try {
            $service = $this->studentBootcampDetailService->execute($studentId);
            return response()->json($service);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

}
