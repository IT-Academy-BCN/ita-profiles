<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Models\Project;
use App\Models\Student;
// use DragonCode\Contracts\Cashier\Auth\Auth;
// use Exception;

class UpdateStudentProjectController extends Controller
{
    public function __invoke(UpdateStudentProjectRequest $request, Student $student, Project $project): JsonResponse
    {
        // I'll work on authentication later. For now, I'll just comment out the code.
        // $user = Auth::user();
        // if ($user->id !== $student->user_id) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $data = $request->validated();

        $project->update($data);

        return response()->json([
            'message' => 'El projecte s\'ha actualitzat',
            'project' => $project
        ], 200);
    }
}
