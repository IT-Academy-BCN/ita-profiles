<?php

declare(strict_types=1);

namespace Service;

use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use App\Models\User;
use App\Service\ResumeTagService\ResumeTagAddService;
use Database\Factories\UserFactory;
use Tests\TestCase;

class ResumeTagAddServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->resumeTagAddService = new ResumeTagAddService();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(ResumeTagAddService::class, $this->resumeTagAddService);
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testExecuteAddsTagsToResume()
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

        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        $this->resumeTagAddService->execute([$tag1->id, $tag2->id]);

        $resume->refresh();
        $this->assertCount(2, json_decode($resume->tags_ids));
    }
}
