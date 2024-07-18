<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Student;
use App\Models\Language;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

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
            // $student = Student::findOrFail($studentId);
            $student = $this->updateStudentLanguagesService->findStudentById($studentId);

            // Obtener el CV del estudiante y sus lenguajes
            // $resume = $student->resume;
            $resume = $this->updateStudentLanguagesService->findStudentResume($student);

            // $languagesToUpdate = $resume->languages;

            // Encontrar el lenguaje solicitado por nombre y nivel
            // $newLanguage = Language::where('language_name', $data['language_name'])
            //     ->where('language_level', $data['language_level'])
            //     ->firstOrFail();

            // Actualizar el language_id en la tabla pivote
            //     foreach ($languagesToUpdate as $languageToUpdate) {
            //         if ($languageToUpdate->language_name === $data['language_name']) {
            //             $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);

            //             return response()->json([
            //                 'message' => 'Language updated successfully',
            //             ]);
            //         }
            //     }

            //     // Si no se encontró el lenguaje
            //     return response()->json([
            //         'message' => 'Language not found for this student'
            //     ], 404);

            // } catch (ModelNotFoundException $e) {
            //     return response()->json([
            //         'message' => 'Student or Language not found',
            //         'error' => $e->getMessage()
            //     ], 404);
            // } catch (Exception $e) {
            //     return response()->json([
            //         'message' => 'An error occurred while updating the language',
            //         'error' => $e->getMessage()
            //     ], 500);
            // }
            if ($this->updateStudentLanguagesService->updateStudentLanguage($resume, $data['language_name'], $data['language_level'])) {
                return response()->json(['message' => 'Language updated successfully']);
            } else {
                return response()->json(['message' => 'Language not found for this student'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student or Language not found', 'error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the language', 'error' => $e->getMessage()], 500);
        }
    }
}
