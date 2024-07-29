<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\UpdateStudentProjectService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\UserNotFoundException;
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
            $this->authorize('canAccessResource', $userProfile);

            $data = $request->all();            
            $this->updateStudentProjectService->execute($studentId, $projectId, $data);
            return response()->json(['message' => 'El projecte s\'ha actualitzat'], 200);
        } catch (UserNotFoundException |StudentNotFoundException | ProjectNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
