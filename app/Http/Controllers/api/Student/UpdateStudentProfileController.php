<?php

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\JsonResponse;

class UpdateStudentProfileController extends Controller
{

    public function __invoke(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $this->authorize('update', $student);
        $data = $request->validated();

        $student->update($data);

        $resume = $student->resume()->firstOrFail();

        $resume->update($data);

        $student->tags()->sync($data['tags_ids']);

        return response()->json([
            'profile' => 'The student\'s profile has been updated successfully',
        ]);
    }
}