<?php

declare(strict_types=1);

namespace Test\Unit\Service\ResumeTagDeleteService;

use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use App\Models\User;
use App\Service\ResumeTagService\ResumeTagDeleteService;
use Database\Factories\UserFactory;
use Tests\TestCase;

class ResumeTagDeleteServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->resumeTagDeleteService = new ResumeTagDeleteService();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(ResumeTagDeleteService::class, $this->resumeTagDeleteService);
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testRemovesSpecifiedTagsFromResume(): void
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

        $this->actingAs($user, 'api');

        $tags = Tag::factory(3)->create();
        $resume->tags_ids = json_encode($tags->pluck('id')->toArray(), 1);
        $resume->save();

        $this->resumeTagDeleteService->removespecifiedTags([$tags[0]->id, $tags[1]->id]);

        $resume->refresh();
        $tagsIdsAfterDelete = json_decode($resume->tags_ids, true);
        self::assertCount(1, $tagsIdsAfterDelete);
        self::assertNotContains($tags[0]->id, $tagsIdsAfterDelete);
        self::assertNotContains($tags[1]->id, $tagsIdsAfterDelete);
    }

    public function testRemoveAllTagsFromResume(): void
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
        $this->actingAs($user, 'api');

        $tags = Tag::factory(3)->create();
        $resume->tags_ids = json_encode($tags->pluck('id')->toArray(), 1);
        $resume->save();
        $this->resumeTagDeleteService->removeAllTags();
        $resume->refresh();
        $this->assertEmpty(json_decode($resume->tags_ids, true));
    }
}
