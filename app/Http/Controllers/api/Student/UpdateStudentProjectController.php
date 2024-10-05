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
        // I think this should go to policy: Ensure the project belongs to the student's resume of the Authenticated user.
        if (!$student->resume->projects->contains($project)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();

        $project->update($data);

        return response()->json([
            'message' => 'El projecte s\'ha actualitzat',
            // 'project' was not being return, should erase it from the response.
            'project' => $project
        ], 200);
    }
}
