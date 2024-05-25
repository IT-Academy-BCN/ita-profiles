<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\StudentLanguageDetailService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentLanguagesDetailController extends Controller
{
    private StudentLanguageDetailService $studentLanguageDetailService;

    public function __construct(StudentLanguageDetailService $studentLanguageDetailService)
    {
        $this->studentLanguageDetailService = $studentLanguageDetailService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->studentLanguageDetailService->execute($studentId);
            return response()->json(['languages' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
