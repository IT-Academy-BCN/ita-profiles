<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\StudentCollaborationService;
use Illuminate\Http\JsonResponse;
use Exception;

class StudentCollaborationController extends Controller
{
    private StudentCollaborationService $studentCollaborationService;

    public function __construct(StudentCollaborationService $studentCollaborationService)
    {
        $this->studentCollaborationService = $studentCollaborationService;
    }
    
    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->studentCollaborationService->execute($studentId);
            return response()->json(['collaborations' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
