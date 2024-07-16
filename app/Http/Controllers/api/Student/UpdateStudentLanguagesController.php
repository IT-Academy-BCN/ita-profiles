<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UpdateStudentLanguagesController extends Controller
{
    public function __invoke(string $studentId): JsonResponse
    {
        return response()->json(['message' => 'Method not implemented']);
    }
}
