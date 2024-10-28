<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Resume;

use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ResumeTest extends TestCase
{

    use DatabaseTransactions;
    public function testCanSetsOriginalGithub_urlWhenUpdating()
    {

        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/original-url',
        ]);

        $resume->github_url = 'https://github.com/updated-url';
        $resume->save();

        $this->assertEquals('https://github.com/original-url', app('originalGitHubUrl'));
    }
}
