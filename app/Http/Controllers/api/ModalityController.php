<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;


class ModalityController extends Controller
{
    public function __invoke($studentId)
    {
        
        $resume = Resume::where('student_id', $studentId)->first();
        
        if (!$resume) {
            return response()->json(['error' => 'No se encontró el currículum del usuario'], 404);
        }

        return response()->json([
            'modality' => $resume->modality
        ], 200);    

    }
}
