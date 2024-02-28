<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentBootcampDetailController extends Controller
{
    public function __invoke($id)
    {
        Student::findOrFail($id);

        $bootcamp_detail = [

            'bootcamp' => [
                [
                    'bootcamp_id' => '1',
                    'bootcamp_name' => 'php Fullstack Developer',
                    'bootcamp_site' => 'IT Academy - Barcelona',
                    'bootcamp_end_date' => ['November 2023'],
                    'bootcamp_workload' => '400 hrs'
                ],
            ]
        ];
        
        return response()->json($bootcamp_detail);
    }
}
