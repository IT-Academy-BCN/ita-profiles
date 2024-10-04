<?php

namespace App\Http\Controllers\api\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;
use Illuminate\Http\{
    JsonResponse,
};

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;

class UpdateStudentProfileController extends Controller
{

    public function __invoke(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $data = $request->validated();

        $student->update($data);

        $resume = $student->resume?->update($data) ?? collect();

        $student->tags()->sync($data['tags_ids'] ?? []);

        return response()->json([
            'profile' => 'El perfil de l\'estudiant s\'actualitza correctament',
            'resume' => $resume,
        ]);

    }
}
