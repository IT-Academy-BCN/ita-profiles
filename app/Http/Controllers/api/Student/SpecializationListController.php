<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecializationListCollection;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;

class SpecializationListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $specializations = $student->resume?->specialization ?? collect();
        return response()->json(new SpecializationListCollection($specializations));
    }
}