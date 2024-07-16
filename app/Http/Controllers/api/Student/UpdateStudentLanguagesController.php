<?php

namespace App\Http\Controllers\api\Student;

use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UpdateStudentLanguagesController extends Controller
{
    private UpdateStudentLanguagesService $updateStudentLanguagesService;

    public function __construct(UpdateStudentLanguagesService $updateStudentLanguagesService)
    {
        $this->updateStudentLanguagesService = $updateStudentLanguagesService;
    }

    public function __invoke(UpdateStudentLanguagesRequest $request, string $studentId): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->updateStudentLanguagesService->execute($studentId, $data['languages']);

            return response()->json([
                'message' => 'Student languages updated successfully',
            ], 200);
        } catch (StudentNotFoundException $e) {
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json("No s'ha pogut actualitzar el nivell dels llenguatges de l'estudiant", 500);
        }
    }
}
