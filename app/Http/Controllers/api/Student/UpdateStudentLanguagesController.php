<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(string $studentId, Request $request): JsonResponse
    {
        $data = $request->validate([
            'language_name' => 'required|exists:languages,language_name',
            'language_level' => 'required|in:Bàsic,Intermedi,Avançat,Natiu'
        ]);

        // Buscar el estudiante
        $student = Student::findOrFail($studentId);

        // Obtener el resume del estudiante
        $resume = $student->resume;

        // Buscar la combinación de language_name y language_level en la tabla languages
        $language = Language::where('language_name', $data['language_name'])
            ->where('language_level', $data['language_level'])
            ->firstOrFail();

        $languagesToUpdate = $resume->languages;



        foreach ($languagesToUpdate as $languageToUpdate) {
            if ($language->language_name === $languageToUpdate->language_name) {
                $languageToUpdate->pivot->language_level = $data['language_level'];

                return response()->json([
                    'message' => 'Language updated successfully',
                ]);
            }
        }

        return \response()->json([
            'message' => 'Language not found'
        ]);





        // return response()->json([
        //     'message' => 'Language updated successfully',
        //     'languages' => $resume->languages
        // ], 200);
    }
}
