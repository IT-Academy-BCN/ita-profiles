<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Illuminate\Http\{
    JsonResponse,
};

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Student;

class DeleteStudentResumeLanguageController extends Controller
{
    public function __invoke(Student $student, Language $language): JsonResponse
    {
        $this->authorize('update', $student);
        $resume = $student->resume()->firstOrFail();
        $resume->languages()->findOrFail($language->id)->pivot->delete();

        return response()->json([], 200);
    }
}
