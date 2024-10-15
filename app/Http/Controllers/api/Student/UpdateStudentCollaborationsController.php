<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaborationsRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateStudentCollaborationsController extends Controller
{
    public function __invoke(CollaborationsRequest $request, Student $student): JsonResponse
    {
        $resume = $student->resume ?? throw new ModelNotFoundException();

        $collaborations = array_filter($request->input('collaborations', []), fn($value) => !is_null($value));

        $resume->collaborations()->sync($collaborations);

        return response()->json(['message' => 'Collaborations updated']);
    }
}
