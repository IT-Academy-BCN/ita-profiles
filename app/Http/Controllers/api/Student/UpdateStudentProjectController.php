<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Models\Project;
use App\Models\Student;

class UpdateStudentProjectController extends Controller
{
    public function __invoke(UpdateStudentProjectRequest $request, Student $student, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $data = $request->validated();

        $project->update($data);

        if (isset($data['tags'])) {
            $project->tags()->sync($data['tags']);
        }

        return response()->json([
            'message' => 'The project has been updated successfully',
        ], 200);
    }
}
