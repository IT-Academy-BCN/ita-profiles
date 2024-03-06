<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentProjectsDetailController extends Controller
{
    public function __invoke($uuid)
    {
        Student::where('id', $uuid)->firstOrFail();

        $projects_detail = [

            'projects' => [
                [
                    'project_id' => '1',
                    'project_name' => 'ITA Project 1',
                    'project_site' => 'Acme Corporation',
                    'project_skills' => ['PHP', 'JavaScript', 'HTML', 'CSS'],
                    'project_repository' => 'https://github.com/user/project1'
                ],
                [
                    'project_id' => '2',
                    'project_name' => 'ITA Project 2',
                    'project_site' => 'Globex Industries',
                    'project_skills' => ['Python', 'Django', 'React'],
                    'project_repository' => 'https://github.com/user/project2'
                ],
                [
                    'project_id' => '3',
                    'project_name' => 'ITA Project 3',
                    'project_site' => 'Wayne Enterprises',
                    'project_skills' => ['Java', 'Spring Boot', 'Angular'],
                    'project_repository' => 'https://github.com/user/project3'
                ]
            ]
        ];

        return response()->json($projects_detail);
    }
}
