<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\StudentAboutService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentDetailController extends Controller
{
    function __invoke(Request $request,$student_id):JsonResponse{

        $studentDetails= Resume::where('student_id',$student_id)->get();

        if ($studentDetails->isEmpty()) {
            return response()->json(['error' => 'No se encontró ningún estudiante con el ID especificado'], 404);
        }
        else{  
            return response()->json($studentDetails, 200);
        }
    }     
}
