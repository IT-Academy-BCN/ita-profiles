<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\StudentUpdateProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;

class StudentUpdateProjectController extends Controller
{
    private $studentUpdateProjectService;

    public function __construct(StudentUpdateProjectService $studentUpdateProjectService)
    {
        $this->studentUpdateProjectService = $studentUpdateProjectService;
    }

    public function __invoke(Request $request, $studentId, $projectId): JsonResponse
    {
        $data = $request->all();
        try {
            $this->studentUpdateProjectService->execute($studentId, $projectId, $data);
            return response()->json(['message' => 'El projecte s\'ha actualitzat'], 200);
        } catch (StudentNotFoundException | ProjectNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
