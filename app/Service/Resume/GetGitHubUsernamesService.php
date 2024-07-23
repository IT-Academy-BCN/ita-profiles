<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
use App\Service\Student\StudentService;
use App\Service\Student\StudentProjectsDetailService;

class getGitHubUsernamesService
{
    private $studentService;
    private $studentProjectsDetailService;

    public function __construct(StudentService $studentService, StudentProjectsDetailService $studentProjectsDetailService)
    {
        $this->studentService = $studentService;
        // $this->studentProjectsDetailService = $studentProjectsDetailService;
    }

    public function GetGitHubUsernames(): array
    {
        $students = $this->studentService->getAllStudents();
        $gitHubUsernames = [];
        foreach ($students as $student) {
            // Quedaría hacer verificaciones... con el handler que prepara Iván o try catch.
            // $resume = $this->studentProjectsDetailService->getResume($student);
            $resume = $this->getResumeByStudentId($student->id);

            // We remove the 'https://github.com/' from github_url and leave only the username.
            $gitHubUsername = str_replace('https://github.com/', '', $resume->github_url);

            $gitHubUsernames[] = [
                'resume_id' => $resume->id,
                'github_username' => $gitHubUsername,
            ];
        }

        return $gitHubUsernames;
    }

    // Esta función habría que ver si está en algún otro service:
    public function getResumeByStudentId(string $studentId): Resume
    {
        $resume = Resume::where('student_id', $studentId)->first();

        return $resume;
    }
}
