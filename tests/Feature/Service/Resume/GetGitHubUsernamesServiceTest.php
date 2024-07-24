<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Resume;
use PHPUnit\Framework\TestCase;
use App\Service\Resume\GetGitHubUsernamesService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetGitHubUsernamesServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new GetGitHubUsernamesService();
    }


    public function testGetGitHubUsernames()
    {
        // VER POR QUE NO PILLA EL RESUME FACTORY Y DA ERROR
        $resumes = Resume::factory()->count(5)->create();

        // $gitHubUsernames = $this->service->getGitHubUsernames();

        // $this->assertIsArray($gitHubUsernames);
        // // Ensure the number of GitHub usernames matches the number of students created
        // $this->assertCount(5, $gitHubUsernames);

    }
}
