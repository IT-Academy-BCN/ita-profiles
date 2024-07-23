<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Service\Student\StudentService;
use App\Service\Student\StudentProjectsDetailService;

class GetGitHubUsernames
{
    private $studentService;
    private $studentProjectsDetailService;

    public function __construct(StudentService $studentService, StudentProjectsDetailService $studentProjectsDetailService)
    {
        $this->studentService = $studentService;
        $this->studentProjectsDetailService = $studentProjectsDetailService;
    }

    public function GetGitHubUsernames(): array
    {
        $students = $this->studentService->getAllStudents();
        $gitHubUsernames = [];
        foreach ($students as $student) {
            // No sé si aquí deberíamos usar un try catch jaja.
            $projectsDetails = $this->studentProjectsDetailService->getResume($student);
            foreach ($projectsDetails as $projectDetail) {
                // Y no sé si aquí también, por si no tiene un githubUserName
                $gitHubUsernames[] = $projectDetail['github_url'];
            }
        }

        return $gitHubUsernames;
    }
}
