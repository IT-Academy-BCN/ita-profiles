<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\UpdateStudentProjectService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateStudentProjectRequest;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;

class UpdateStudentProjectController extends Controller
{
    private $studentUpdateProjectService;

    public function __construct(UpdateStudentProjectService $studentUpdateProjectService)
    {
        $this->studentUpdateProjectService = $studentUpdateProjectService;
    }

    public function __invoke(UpdateStudentProjectRequest $request, $studentId, $projectId): JsonResponse
    {       
        try {
            $data = $request->all();            
            $this->studentUpdateProjectService->execute($studentId, $projectId, $data);
            return response()->json(['message' => 'El projecte s\'ha actualitzat'], 200);
        } catch (StudentNotFoundException | ProjectNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
