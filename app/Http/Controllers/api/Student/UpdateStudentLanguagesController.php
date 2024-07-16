<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Service\Student\UpdateStudentLanguageService;

class StudentController extends Controller
{
    public function updateLanguage(UpdateStudentLanguagesRequest $request, string $studentId)
    {
        $data = $request->validated();

        $service = new UpdateStudentLanguageService();
        $service->execute($studentId, $data);

        return response()->json(['message' => 'Language level updated successfully']);
    }
}
