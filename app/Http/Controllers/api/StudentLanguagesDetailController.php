<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\Student\LanguageService;
use App\Exceptions\LanguageNotFoundException;
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

    public function __invoke($studentId): JsonResponse
    {
        try {
            $service = $this->languageService->execute($studentId);
            return response()->json(['languages' => $service]);
        } catch (StudentNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (LanguageNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
