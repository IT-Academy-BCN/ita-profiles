<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentModalityController extends Controller
{

    public function __invoke(Student $student): JsonResponse
    {
        $resume = $student->resume ?? throw new ModelNotFoundException();
        $modality = $resume->modality;

        return response()->json(['modality' => $modality]);
    }
}
