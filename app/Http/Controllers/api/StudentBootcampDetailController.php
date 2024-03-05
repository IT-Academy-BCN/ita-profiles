<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentBootcampDetailController extends Controller
{
    public function __invoke($uuid)
    {
        Student::where('id', $uuid)->firstOrFail();

        $bootcamp_detail = [

            'bootcamp' => [
                [
                    'bootcamp_id' => '1',
                    'bootcamp_name' => 'php Fullstack Developer',
                    'bootcamp_end_date' => ['November 2023'],
                ],
            ]
        ];
        
        return response()->json($bootcamp_detail);
    }
}
