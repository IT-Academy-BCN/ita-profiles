<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(string $studentId, Request $request): JsonResponse
    {
        $data = $request->validate([
            'language_name' => 'required|exists:languages,language_name',
            'language_level' => 'required|in:Bàsic,Intermedi,Avançat,Natiu'
        ]);

        $student = Student::find($studentId);

        $resume = $student->resume;

        $languages = $resume->languages;

        // search the language_id combination of the language_name and language_level on languages table
        $language_combination = $languages->where('language_name', $data['language_name'])->where('language_level', $data['language_level'])->first();

        $language_combination_id = $language_combination->id;

        // update the language_id of language in $languages

        foreach ($languages as $language) {
            if ($language->id == $language_combination_id) {
                $language->id = $language_combination_id;
            }

            $language->save();
        }
        return response()->json('Language updated successfully', 200);
    }
}
