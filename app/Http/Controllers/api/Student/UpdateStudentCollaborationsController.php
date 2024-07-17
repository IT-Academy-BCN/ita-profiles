<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaborationsRequest;
use App\Service\Student\UpdateStudentCollaborationsService;
use Exception;
use Illuminate\Http\JsonResponse;

class UpdateStudentCollaborationsController extends Controller
{
    private UpdateStudentCollaborationsService $updateStudentCollaborationsService;


    public function __construct(UpdateStudentCollaborationsService $updateStudentCollaborationsService)
    {
        $this->updateStudentCollaborationsService = $updateStudentCollaborationsService;
    }

    public function __invoke(CollaborationsRequest $request, string $studentId): JsonResponse
    {
        try {
            $this->updateStudentCollaborationsService->updateCollaborationsByStudentId($studentId, $request);
            return response()->json([
                'message' => __("Collaborations updated successfully"),
            ]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
