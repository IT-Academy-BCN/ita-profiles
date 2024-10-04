<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Resources\AdditionalTrainingCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Student;

class StudentAdditionalTrainingListController extends Controller
{
       public function __invoke(Student $student): JsonResponse
    {
      $additionalTrainings = $student->resume?->additionalTrainings ?? collect();
    
      return response()->json(new AdditionalTrainingCollection($additionalTrainings));
    }
}
