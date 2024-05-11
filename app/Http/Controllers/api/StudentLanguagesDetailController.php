<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\LanguageService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentLanguagesDetailController extends Controller
{
    private LanguageService $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->languageService->execute($studentId);
            return response()->json($service);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
