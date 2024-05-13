<?php
declare(strict_types=1); 
namespace App\Http\Controllers\api;
use Exception;
use App\Http\Controllers\Controller;
use App\Service\StudentDetailService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentDetailController extends Controller
{
    private StudentDetailService $studentDetailsService;

    public function __construct(StudentDetailService $studentDetailsService)
    {
        $this->studentDetailsService = $studentDetailsService;
    }
    public function __invoke($studentId):JsonResponse
    {
        try {
            $service = $this->studentDetailsService->execute($studentId);
            return response()->json(['data'=> [$service]]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }  
}
