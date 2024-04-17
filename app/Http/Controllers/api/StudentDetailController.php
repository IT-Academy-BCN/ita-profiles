<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\StudentAboutService;
use Illuminate\Http\Request;


class StudentDetailController extends Controller
{
    public function __invoke()
    {
        $data = file_get_contents(base_path('database/data/studentDetail.json'));

        return response()->json(json_decode($data, true));
    }


        protected $studentAboutService;
    
        public function __construct(StudentAboutService $studentAboutService)
        {
            $this->studentAboutService = $studentAboutService;
        }
    
        public function getAbout(Request $request, $student_id)
        {
            try {
                $about = $this->studentAboutService->getAboutByStudentId($student_id);
                return response()->json(['about' => $about], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['message' => 'Estudiante no encontrado'], 404);
            }
        }
    
}
