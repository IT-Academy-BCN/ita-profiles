<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Student;
use App\Models\Language;
use Illuminate\Http\JsonResponse;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(string $studentId, UpdateStudentLanguagesRequest $request): JsonResponse
    {
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

        // Variable para verificar si el lenguaje fue encontrado
        $languageFound = false;

        // Actualizar el language_id en la tabla pivote
        foreach ($languagesToUpdate as $languageToUpdate) {
            if ($languageToUpdate->language_name === $data['language_name']) {
                // Actualizar el language_id en la tabla pivote
                $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);

                $languageFound = true;

                return response()->json([
                    'message' => 'Language updated successfully',
                ]);
            }
        }

        if (!$languageFound) {
            return response()->json([
                'message' => 'Language not found'
            ]);
        }
    }
}
