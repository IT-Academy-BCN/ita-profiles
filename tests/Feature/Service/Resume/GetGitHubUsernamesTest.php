<?php

declare(strict_types=1);

use App\Models\Resume;
use App\Models\Student;
use PHPUnit\Framework\TestCase;
use App\Service\Resume\GetGitHubUsernames;
use App\Service\Student\StudentProjectsDetailService;
use App\Service\Student\StudentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetGitHubUsernamesTest extends TestCase
{
    use DatabaseTransactions;
    private $studentService;
    private $studentProjectsDetailService;

    public function setUp(): void
    {
        parent::setUp();
        $this->studentService = new StudentService();
        $this->studentProjectsDetailService = new StudentProjectsDetailService();
    }


    public function testGetGitHubUsernames()
    {
        $students = Student::factory()->count(5)->create();
        foreach ($students as $student) {
            $student->resume()->save(Resume::factory()->make());
        }

        $service = new GetGitHubUsernames($this->studentService, $this->studentProjectsDetailService);
        $gitHubUsernames = $service->GetGitHubUsernames();

        $this->assertIsArray($gitHubUsernames);
        // Ensure the number of GitHub usernames matches the number of students created
        $this->assertCount(5, $gitHubUsernames);
        // Optionally, check for specific GitHub usernames if you have set expectations
        foreach ($gitHubUsernames as $username) {
            $this->assertStringStartsWith('https://github.com/', $username);
        }
    }
}
