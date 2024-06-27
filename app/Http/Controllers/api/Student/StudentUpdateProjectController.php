<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\StudentUpdateProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentUpdateProjectController extends Controller
{
    private $studentUpdateProjectService;

    public function __construct(StudentUpdateProjectService $studentUpdateProjectService)
    {
        $this->studentUpdateProjectService = $studentUpdateProjectService;
    }

    public function __invoke(Request $request, $studentId, $projectId): JsonResponse
    {
        $this->validate($request, [
            'project_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'project_url' => 'nullable|url',
            'tags' => 'array',
            'tags.*' => 'string',
            'github_url' => 'nullable|url',
        ]);

        try {
            $project = $this->studentUpdateProjectService->execute($studentId, $projectId, $request->all());
            return response()->json(['project' => $project]);
        } catch (StudentNotFoundException | ResumeNotFoundException | ProjectNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
