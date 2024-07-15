<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Exception;
use App\Http\Controllers\Controller;
use App\Service\Student\UpdateStudentSkillsService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SkillsRequest;
use App\Models\User;
use App\Models\Student;


class UpdateStudentSkillsController extends Controller
{
    private UpdateStudentSkillsService $updateStudentSkillsService;

    public function __construct(UpdateStudentSkillsService $updateStudentSkillsService)
    {
        $this->updateStudentSkillsService = $updateStudentSkillsService;
    }

    public function __invoke(SkillsRequest $request, string $studentId): JsonResponse
    {
        try {
            // Fetch the Student model instance by id
            $student = Student::find($studentId);

            // Fetch the User model associated with the Student's user_id
            $userProfile = User::where('id', $student->user_id)->firstOrFail();

            // Use the 'canAccessResource' policy method to authorize the request
            $this->authorize('canAccessResource', $userProfile);

            $service = $this->updateStudentSkillsService->updateSkillsByStudentId($studentId, $request->skills);

            return response()->json(['status' => 'success'], 200);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
