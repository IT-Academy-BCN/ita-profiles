<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

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
        $dataStudentProfileUpdate = $request->only(['name', 'surname', 'subtitle' , 'github_url', 'linkedin_url', 'about']);

        DB::beginTransaction();
        try {
            $this->updateStudentProfileService->execute($studentId, $dataStudentProfileUpdate);
            DB::commit();

                return response()->json([
                    'profile'=> 'El perfil del estudiante se actualizo correctamente'
                ], 200);
        } catch (\DomainException $e) {
            DB::rollBack();
            Log::error('Domain exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('El perfil del estudiante no se pudo actualizar, por favor intentelo de nuevo', 500);
        }

    }


}
