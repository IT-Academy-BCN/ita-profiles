<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\StudentProjectsDetailService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;



class StudentProjectsDetailController extends Controller
{
    private $studentProjectsDetailService;

    public function __construct(StudentProjectsDetailService $studentProjectsDetailService)
    {
        $this->studentProjectsDetailService = $studentProjectsDetailService;
    }

    public function __invoke($studentId): JsonResponse
    {
        try {
            $service = $this->studentProjectsDetailService->execute($studentId);
            return response()->json(['projects' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {  
            return response()->json(['message' => $e->getMessage()], $e->getCode());  
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
