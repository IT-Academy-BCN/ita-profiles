<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Student;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(string $studentId, UpdateStudentLanguagesRequest $request): JsonResponse
    {
        try {
            // Validar los datos de la request
            $data = $request->validated();

            // Encontrar el estudiante por ID
            $student = Student::findOrFail($studentId);

            // Obtener el CV del estudiante y sus lenguajes
            $resume = $student->resume;
            $languagesToUpdate = $resume->languages;

            // Encontrar el lenguaje solicitado por nombre y nivel
            $newLanguage = Language::where('language_name', $data['language_name'])
                ->where('language_level', $data['language_level'])
                ->firstOrFail();

            // Actualizar el language_id en la tabla pivote
            foreach ($languagesToUpdate as $languageToUpdate) {
                if ($languageToUpdate->language_name === $data['language_name']) {
                    $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);

                    return response()->json([
                        'message' => 'Language updated successfully',
                    ]);
                }
            }

            // Si no se encontró el lenguaje
            return response()->json([
                'message' => 'Language not found for this student'
            ], 404);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Student or Language not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the language',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
