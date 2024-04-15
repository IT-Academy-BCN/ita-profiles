<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentBootcampDetailController extends Controller
{
    private StudentBootcampDetailService $studentBootcampDetailService;

    public function __construct(StudentBootcampDetailService $studentBootcampDetailService)
    {
        $this->studentBootcampDetailService = $studentBootcampDetailService;
    }

    public function __invoke(Student $student): JsonResponse
    {
        try {
            $service = $this->studentBootcampDetailService->execute($student->id);

            return response()->json($service);
        } catch (Exception $exception) {

            return response($exception->getMessage(), $exception->getCode())->json();
        }
    }
}
