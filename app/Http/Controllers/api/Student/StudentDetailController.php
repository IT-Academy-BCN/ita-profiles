<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentDetailController extends Controller
{
    public function __invoke(Student $student): JsonResponse
    {
        return response()->json($student);
    }
}
