<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentBootcampDetailController extends Controller
{
    public function __invoke($uuid)
    {
        // Student::where('id', $uuid)->firstOrFail();

        $bootcamp_detail = [

            'bootcamp' => [
                [
                    'bootcamp_id' => '1',
                    'bootcamp_name' => 'Full Stack PHP',
                    'bootcamp_end_date' => ['November 2023'],
                ],
                [
                    'bootcamp_id' => '2',
                    'bootcamp_name' => 'Back End Nodejs',
                    'bootcamp_end_date' => ['December 2023'],
                ],
                [
                    'bootcamp_id' => '3',
                    'bootcamp_name' => 'Data Analytics',
                    'bootcamp_end_date' => ['January 2024'],
                ],
                [
                    'bootcamp_id' => '4',
                    'bootcamp_name' => 'Front End Angular',
                    'bootcamp_end_date' => ['December 2022'],
                ],
                [
                    'bootcamp_id' => '5',
                    'bootcamp_name' => 'Front End React',
                    'bootcamp_end_date' => ['October 2022'],
                ],
            ]
        ];
        
        $random_bootcamp_index = array_rand($bootcamp_detail['bootcamp']);
        $random_bootcamp = $bootcamp_detail['bootcamp'][$random_bootcamp_index];

        return response()->json($random_bootcamp);
    }
}