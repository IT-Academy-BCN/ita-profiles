<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Models\Language;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddStudentLanguageRequest;

class AddStudentLanguageController extends Controller
{
    public function __invoke(AddStudentLanguageRequest $request, Student $student): JsonResponse
    {
        $this->authorize('update', $student);

        $data = $request->validated();
        $resume = $student->resume()->firstOrFail();
        $language = Language::findOrFail($data['language_id']);


        $resume->languages()->sync([$language->id], false);

        return response()->json(['message' => 'L\'idioma s\'ha afegit']);
    }
}
