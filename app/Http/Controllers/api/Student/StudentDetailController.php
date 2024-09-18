<?php

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

class StudentDetailController extends Controller
{
    public function __invoke(Student $student): JsonResponse
    {
        return response()->json(new StudentResource($student));
    }
}
