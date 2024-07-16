<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\UpdateStudentSkillsService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SkillsRequest;

use App\Service\Student\StudentService;


class UpdateStudentSkillsController extends Controller
{
    private UpdateStudentSkillsService $updateStudentSkillsService;
    private StudentService $studentService;

    public function __construct(UpdateStudentSkillsService $updateStudentSkillsService, StudentService $studentService)
    {
        $this->updateStudentSkillsService = $updateStudentSkillsService;
        $this->studentService = $studentService;
    }

    public function __invoke(SkillsRequest $request, string $studentId): JsonResponse
    {
        try {
            // IF USING POLICIES: Fetch the User model associated with the Student's user_id
            $userProfile = $this->studentService->findUserByStudentID($studentId);
            // Use the 'canAccessResource' policy method to authorize the request
            $this->authorize('canAccessResource', $userProfile);

            $this->updateStudentSkillsService->updateSkillsByStudentId($studentId, $request->skills);

            return response()->json(['status' => 'success'], 200);
        } catch (UserNotFoundException | StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
