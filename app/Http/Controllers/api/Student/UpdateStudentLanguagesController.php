<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Student;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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

        Log::info("The actual languages of the student are:", [
            'student_id' => $studentId,
            'languages' => $languagesToUpdate->pluck('language_name')
        ]);

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

                // Log para confirmar la transacción
                Log::info("Language updated successfully", [
                    'student_id' => $studentId,
                    'old_language_id' => $languageToUpdate->id,
                    'new_language_id' => $newLanguage->id,
                    'language_name' => $data['language_name'],
                    'language_level' => $data['language_level']
                ]);

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
