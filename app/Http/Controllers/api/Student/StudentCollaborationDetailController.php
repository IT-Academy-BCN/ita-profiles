<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\Student\StudentCollaborationdetailService;
use Illuminate\Http\JsonResponse;
use Exception;

class StudentCollaborationDetailController extends Controller
{
    private StudentCollaborationDetailService $studentCollaborationDetailService;

    public function __construct(StudentCollaborationDetailService $studentCollaborationDetailService)
    {
        $this->studentCollaborationDetailService = $studentCollaborationDetailService;
    }
    
    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->studentCollaborationDetailService->execute($studentId);
            return response()->json(['collaborations' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
