<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Service\Student\StudentBootcampDetailService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class StudentBootcampDetailController extends Controller
{
    private StudentBootcampDetailService $studentBootcampDetailService;

    public function __construct(StudentBootcampDetailService $studentBootcampDetailService)
    {
        $this->studentBootcampDetailService = $studentBootcampDetailService;
    }
    /**
     * Handle the incoming request to get bootcamp details for a specific student.
     *
     * @param string $studentId The UUID of the student.
     * @throws Exception If an error occurs while executing the function.
     * @return JsonResponse The JSON response containing containing bootcamp details.
     */
    public function __invoke($studentId): JsonResponse
    {
        try {
            $service = $this->studentBootcampDetailService->execute($studentId);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (Exception $exception) {
            $responseCode = $exception->getCode() > 0 && $exception->getCode() < 600 ? $exception->getCode() : 500;
            return response()->json([$exception->getMessage()], $responseCode);
        }
    }
}
