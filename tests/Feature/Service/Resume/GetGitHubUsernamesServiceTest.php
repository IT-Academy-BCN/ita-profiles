<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Resume;
use Tests\TestCase;
use App\Service\Resume\GetGitHubUsernamesService;
use App\Service\Resume\ResumeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetGitHubUsernamesServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $getGitHubUsernamesService;
    private $resumeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
        $this->getGitHubUsernamesService = new GetGitHubUsernamesService($this->resumeService);
    }

    public function testGetGitHubUsernamesServiceReturnsArray()
    {
        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1',
        ]);

        $gitHubUsernames = $this->getGitHubUsernamesService->getGitHubUsernames();

        $this->assertIsArray($gitHubUsernames);

    }

    public function testExceptionThrownForInvalidGitHubUrl()
{
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Invalid GitHub URL: https://notgithub.com/user2");

    Resume::factory()->create([
        'github_url' => 'https://notgithub.com/user2',
    ]);

    $this->getGitHubUsernamesService->getGitHubUsernames();
}
}
