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
            
            $data = $request->validated();
           
            $student = $this->updateStudentLanguagesService->findStudentById($studentId);
            
            $resume = $this->updateStudentLanguagesService->findStudentResume($student);

            if ($this->updateStudentLanguagesService->updateStudentLanguage($resume, $data['language_name'], $data['language_level'])) {
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
