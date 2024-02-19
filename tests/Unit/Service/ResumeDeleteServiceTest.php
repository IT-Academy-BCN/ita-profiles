<?php

declare(strict_types=1);

namespace Service;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use App\Service\Resume\ResumeDeleteService;
use Database\Factories\UserFactory;
use Tests\TestCase;

class ResumeDeleteServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->resumeDeleteService = new ResumeDeleteService();
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(ResumeDeleteService::class, $this->resumeDeleteService);
    }

    public function testCanDeleteAnExistingModel(): void
    {
        $userFactory = new UserFactory();
        $definition = $userFactory->definition();
        $user = new User($definition);
        $user->save();
        $this->actingAs($user, 'api');

        $student = new Student();
        $student->setUniqueIds();
        $student->user_id = $user->id;
        $student->subtitle = '';
        $student->save();

        $resume = new Resume();
        $resume->student_id = $student->id;
        $resume->subtitle = '';
        $resume->save();

        $this->resumeDeleteService->execute($resume->id);

        $actualResume = Resume::find($resume->id);
        self::assertNull($actualResume);
    }
}
