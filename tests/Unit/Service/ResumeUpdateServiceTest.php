<?php

declare(strict_types=1);

namespace Service;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use App\Service\Resume\ResumeUpdateService;
use Database\Factories\UserFactory;
use Tests\TestCase;

class ResumeUpdateServiceTest extends TestCase
{
    public const A_SUBTITLE = 'a subtitle';
    public const HTTPS_A_LINKEDIN_URL = 'https://a-linkedin.url';
    public const HTTPS_A_GITHUB_URL = 'https://a-github.url';
    public const A_SPECIALIZATION = 'Frontend';

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeUpdateService = new ResumeUpdateService();
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(ResumeUpdateService::class, $this->resumeUpdateService);
    }

    public function testCanUpdateAnExistingModel(): void
    {
        $userFactory = new UserFactory();
        $definition = $userFactory->definition();
        $user = new User($definition);
        $user->save();

        $student = new Student();
        $student->setUniqueIds();
        $student->user_id = $user->id;
        $student->subtitle = '';
        $student->save();

        $resume = new Resume();
        $resume->student_id = $student->id;
        $resume->subtitle = '';
        $resume->save();

        $this->resumeUpdateService->execute(
            $resume->getAttributeValue('id'),
            self::A_SUBTITLE,
            self::HTTPS_A_LINKEDIN_URL,
            self::HTTPS_A_GITHUB_URL,
            self::A_SPECIALIZATION
        );

        $actualResume = Resume::find($resume->id);

        self::assertEquals(self::A_SUBTITLE, $actualResume->subtitle);
        self::assertEquals(self::HTTPS_A_LINKEDIN_URL, $actualResume->linkedin_url);
        self::assertEquals(self::HTTPS_A_GITHUB_URL, $actualResume->github_url);
        self::assertEquals(self::A_SPECIALIZATION, $actualResume->specialization);
    }
}
