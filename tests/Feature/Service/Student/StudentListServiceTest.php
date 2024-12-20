<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\StudentListService;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected StudentListService $studentListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentListService = new StudentListService();
    }

    public function testExecuteReturnsExpectedData(): void
    {
        $tag = Tag::factory()->create(attributes: ['name' => 'tag1']);

        $student = Student::factory()->create();
        $student->tags()->attach($tag->id);

        $resume = Resume::factory()->create(attributes: [
            'student_id' => $student->id,
            'specialization' => 'Backend'
        ]);

        $data = $this->studentListService->execute(specializations: ['Backend'], tags: ['tag1']);

        $this->assertCount(1, $data);
        $this->assertEquals($resume->student->id, $data[0]['id']);
        $this->assertEquals($resume->student->name . " " . $resume->student->surname, $data[0]['fullname']);
        $this->assertEquals($resume->subtitle, $data[0]['subtitle']);
        $this->assertCount(1, $data[0]['tags']);
        $this->assertEquals($tag->id, $data[0]['tags'][0]['id']);
        $this->assertEquals($tag->name, $data[0]['tags'][0]['name']);
    }

    public function testExecuteThrowsModelNotFoundExceptionWhenNoResumes(): void
    {
        Resume::query()->delete();

        $this->expectException(ModelNotFoundException::class);

        $this->studentListService->execute(null, null);
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(StudentListService::class, $this->studentListService);
    }
}
