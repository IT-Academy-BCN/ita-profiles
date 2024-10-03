<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Student;

class StudentAdditionalTrainingListController extends Controller
{
       public function __invoke(Student $student): JsonResponse
    {
       return response()->json($student->resume->additionalTrainings);
    }
}
