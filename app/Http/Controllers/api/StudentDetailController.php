<?php
declare(strict_types=1); 
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\StudentDetailsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentDetailsNotFoundException;

class StudentDetailController extends Controller
{
    private StudentDetailsService $studentDetailsService;

    public function __construct(StudentDetailsService $studentDetailsService)
    {
        $this->studentDetailsService =$studentDetailsService;
    }
    function __invoke(Request $request,$student):JsonResponse
    {
        try {
            $service = $this->studentDetailsService->execute($student);
            return response()->json(['student'=> $service], 200);
        } catch (StudentDetailsNotFoundException $e) {
            return response()->json(['message' => 'No hem trobat cap estudiant amb aquest ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperat'], 500);
        }
    }  
}
