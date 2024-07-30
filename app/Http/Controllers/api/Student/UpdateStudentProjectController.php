<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\UpdateStudentProjectService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Service\Student\StudentService;

class UpdateStudentProjectController extends Controller
{
    private UpdateStudentProjectService $updateStudentProjectService;

    private StudentService $studentService;

    public function __construct(UpdateStudentProjectService $updateStudentProjectService, StudentService $studentService)
    {
        $this->updateStudentProjectService = $updateStudentProjectService;
        $this->studentService = $studentService;
    }

    public function __invoke(UpdateStudentProjectRequest $request, $studentId, $projectId): JsonResponse
    {
        try {
            $userProfile = $this->studentService->findUserByStudentID($studentId);        

            $data = $request->all();
            $this->updateStudentProjectService->execute($studentId, $projectId, $data);
            return response()->json(['message' => 'El projecte s\'ha actualitzat'], 200);
        } catch (Exception $e) {
            // Catch any exceptions and return a consistent JSON response
            $status = $e->getCode() ?: 500;
            $message = $e->getMessage();

            // Handle specific exceptions for clearer messages
            if ($message === 'Student not found') {
                return response()->json(['message' => 'Student not found'], 404);
            }
            if ($message === 'Project not found') {
                return response()->json(['message' => 'Project not found'], 404);
            }
            if ($message === 'No tienes permiso para actualizar este proyecto.') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Generic error message
            return response()->json(['message' => $message], $status);
        }
    }
}
