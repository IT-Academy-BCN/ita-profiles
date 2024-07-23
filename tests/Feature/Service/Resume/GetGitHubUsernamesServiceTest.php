<?php

declare(strict_types=1);

use App\Models\Resume;
use PHPUnit\Framework\TestCase;
use App\Service\Resume\GetGitHubUsernamesService;
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
        // Hay que rehacer el test!!!
        // $resumes = Resume::factory()->count(5)->create();

        // $service = new GetGitHubUsernamesService($this->studentService, $this->studentProjectsDetailService);
        // $gitHubUsernames = $service->GetGitHubUsernames();

        // $this->assertIsArray($gitHubUsernames);
        // // Ensure the number of GitHub usernames matches the number of students created
        // $this->assertCount(5, $gitHubUsernames);

    }
}
