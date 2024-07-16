<?php

namespace App\Http\Controllers\api\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Http\{
    JsonResponse,
};
use Illuminate\Support\Facades\{
    DB,
    Log
};
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;
use App\Service\Student\UpdateStudentProfileService;

class UpdateStudentProfileController extends Controller
{
    private UpdateStudentProfileService $updateStudentProfileService;

    public function __construct(UpdateStudentProfileService $updateStudentProfileService)
    {
        $this->updateStudentProfileService = $updateStudentProfileService;
    }

    public function __invoke(UpdateStudentRequest $request, string $studentId): JsonResponse
    {
        $dataStudentProfileUpdate = $request->validated();

        DB::beginTransaction();
        try {
            $this->updateStudentProfileService->execute($studentId, $dataStudentProfileUpdate);
            DB::commit();

            return response()->json([
                'profile' => 'El perfil de l\'estudiant s\'actualitza correctament'
            ], 200);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('El perfil de l\'estudiant no s\'ha pogut actualitzar, si us plau proveu-ho de nou', 500);
        }
    }
}
