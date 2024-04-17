<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\StudentAboutService;
use Illuminate\Http\Request;
use Symfony\Polyfill\Intl\Idn\Idn;

class StudentDetailController extends Controller
{
    function __invoke(Request $request,$id){
        if(!$id){
            return response()->json(['error' => 'ID de estudiante no válido'], 400);
        }
        else{
            $studentDetails= Resume::where('student_id',$id)->get();
            return response()->json($studentDetails, 200);
        }
    
    }

    
    
}
