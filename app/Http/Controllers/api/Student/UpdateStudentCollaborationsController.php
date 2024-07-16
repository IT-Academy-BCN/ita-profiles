<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollaborationsRequest;
use App\Service\Student\UpdateStudentCollaborationsService;
use Illuminate\Http\JsonResponse;

class UpdateStudentCollaborationsController extends Controller
{
    private UpdateStudentCollaborationsService $updateStudentCollaborationsService;

    // We are not using try catch block to bubble up exceptions.
    // We are using Handler.php instead to register callbacks.
    public function __construct(UpdateStudentCollaborationsService $updateStudentCollaborationsService)
    {
        $this->updateStudentCollaborationsService = $updateStudentCollaborationsService;
    }
    public function __invoke(CollaborationsRequest $request, string $studentId): JsonResponse
    {
        $this->updateStudentCollaborationsService->updateCollaborationsByStudentId($studentId, $request);
        return response()->json([
            'message' => __("Collaborations updated successfully"),
        ]);
    }
}
