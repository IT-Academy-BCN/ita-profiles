<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Service\Student\UpdateStudentLanguageService;
use Illuminate\Http\JsonResponse;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(UpdateStudentLanguagesRequest $request, string $studentId): JsonResponse
    {
        $data = $request->validated();

        $service = new UpdateStudentLanguageService();
        $service->execute($studentId, $data);

        return response()->json(['message' => 'Language level updated successfully']);
    }
}
