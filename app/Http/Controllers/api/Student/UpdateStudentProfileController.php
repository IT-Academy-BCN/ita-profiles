<?php

namespace App\Http\Controllers\api\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;
use Illuminate\Http\{
    JsonResponse,
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

    /**
     * @throws ResumeNotFoundException
     */
    public function __invoke(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $dataStudentProfileUpdate = $request->validated();

        $this->updateStudentProfileService->execute($student, $dataStudentProfileUpdate);

        return response()->json([
            'profile' => 'El perfil de l\'estudiant s\'actualitza correctament'
        ]);


    }
}
