<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateStudentLanguagesController extends Controller
{
    private UpdateStudentLanguagesService $updateStudentLanguagesService;

    public function __construct(UpdateStudentLanguagesService $updateStudentLanguagesService)
    {
        $this->updateStudentLanguagesService = $updateStudentLanguagesService;
    }

    public function __invoke(string $studentId, UpdateStudentLanguagesRequest $request): JsonResponse
    {
        try {
            // Validar los datos de la request
            $data = $request->validated();

            // Encontrar el estudiante por ID
            $student = $this->updateStudentLanguagesService->findStudentById($studentId);

            // Encontrar el idioma por nombre y nivel
            $resume = $this->updateStudentLanguagesService->findStudentResume($student);

            if ($this->updateStudentLanguagesService->updateStudentLanguage($resume, $data['name'], $data['level'])) {
                return response()->json(['message' => 'Language updated successfully']);
            } else {
                return response()->json(['message' => 'Language not found for this student'], 404);
            }
        } catch (ModelNotFoundException $e) {
            Log::error('Model not found', ['error' => $e->getMessage(), 'studentId' => $studentId, 'data' => $request->all()]);
            return response()->json(['message' => 'Student or Language not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating student language', ['error' => $e->getMessage(), 'studentId' => $studentId, 'data' => $request->all()]);
            return response()->json(['message' => 'An error occurred while updating the language'], 500);
        }
    }
}
