<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Models\Project;
use App\Models\Student;
use App\Models\Tag;

class UpdateStudentProjectController extends Controller
{
    public function __invoke(UpdateStudentProjectRequest $request, Student $student, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $data = $request->validated();

        $project->update($data);

        if (isset($data['tags'])) {
            $allTags = collect($data['tags'])->map(function ($tagName) {
                return Tag::whereRaw('LOWER(name) = ?', [strtolower($tagName)])
                    ->firstOrCreate(['name' => $tagName]);
            });

            $project->tags()->sync($allTags->pluck('id')->toArray());
        }

        return response()->json([
            'message' => 'El projecte s\'ha actualitzat',
        ], 200);
    }
}
