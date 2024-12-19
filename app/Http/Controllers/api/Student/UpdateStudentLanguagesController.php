<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Language;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(Student $student, UpdateStudentLanguagesRequest $request): JsonResponse
    {
        $this->authorize('update', $student);
        $data = $request->validated();
        $resume = $student->resume()->firstOrFail();

        $newLanguage = Language::query()
            ->where('name', $data['name'])
            ->where('level', $data['level'])
            ->firstOrFail();

        $languagesToUpdate = $resume->languages()->get();

        foreach ($languagesToUpdate as $languageToUpdate) {
            if ($languageToUpdate->name === $data['name']) {
                $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);
            }
        }

        return response()->json(['message' => 'The Language has been added successfully']);
    }
}
