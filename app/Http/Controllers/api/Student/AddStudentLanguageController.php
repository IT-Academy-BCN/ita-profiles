<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\AddStudentLanguageService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddStudentLanguageRequest;

class AddStudentLanguageController extends Controller
{
    private AddStudentLanguageService $addStudentLanguageService;

    public function __construct(AddStudentLanguageService $addStudentLanguageService)
    {
        $this->addStudentLanguageService = $addStudentLanguageService;
    }

    public function store(AddStudentLanguageRequest $request, string $studentId): JsonResponse
    {
        try {
            $data = $request->all(); 
            $service = $this->addStudentLanguageService->execute($studentId, $data);
            return response()->json(['message' => 'L\'idioma s\'ha afegit', 'languages' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
