<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;


class ModalityController extends Controller
{
    public function __invoke($studentId)
    {
        try {
            $resume = Resume::where('student_id', $studentId)->first();

            if (!$resume) {
                throw new \Exception('No se encontró el currículum del usuario', 404);
            }

            return response()->json([
                'modality' => $resume->modality
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
