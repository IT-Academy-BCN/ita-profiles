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
			
            $service = $this->updateStudentSkillsService->updateSkillsByStudentId($studentId, $request->skills);
			return response()->json(['status' => 'success'], 200);

            
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
