<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\BootcampCollection;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentBootcampDetailController extends Controller
{
    public function __invoke(Student $student): JsonResponse
    {
        $bootcamps = $student->resume->bootcamps;

        return response()->json(BootcampCollection::make($bootcamps));
    }
}
