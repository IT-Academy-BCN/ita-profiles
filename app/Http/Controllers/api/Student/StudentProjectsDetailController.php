<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCollection;
use Illuminate\Http\JsonResponse;
use App\Models\Student;

class StudentProjectsDetailController extends Controller
{
    public function __invoke(Student $student): JsonResponse
    {
        $projects = $student->resume?->projects ?? collect();
        return response()->json(new ProjectCollection($projects));
    }
}
