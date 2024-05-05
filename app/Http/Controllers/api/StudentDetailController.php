<?php
declare(strict_types=1); 
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\StudentDetailsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentNotFoundException;

class StudentDetailController extends Controller
{
    private StudentDetailsService $studentDetailsService;

    public function __construct(StudentDetailsService $studentDetailsService)
    {
        $this->studentDetailsService =$studentDetailsService;
    }
    function __invoke($studentId):JsonResponse
    {
        try {
            $service = $this->studentDetailsService->execute($studentId);
            return response()->json(['data'=> [$service]], 200);
        } catch (StudentNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperat'], 500);
        }
    }  
}
