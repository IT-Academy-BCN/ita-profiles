<?php
declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Models\Student;
use App\Service\Student\GetStudentImageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetStudentImageServiceTest extends TestCase
{
    use DatabaseTransactions;

    private GetStudentImageService $getStudentImageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getStudentImageService = new GetStudentImageService();
    }

    private function createFakeData(): Student
    {
        return Student::factory()->create();
    }

    public function test_can_instantiate_service(): void
    {
        $this->assertInstanceOf(GetStudentImageService::class, $this->getStudentImageService);
    }

    public function test_can_get_student_image(): void
    {
        $student = $this->createFakeData();
        $studentPhoto = $this->getStudentImageService->execute($student->id);
        $this->assertIsString($studentPhoto);
    }

    public function test_cannot_get_student_image_null_photo(): void
    {
        $student = $this->createFakeData();
        $student->photo = null;
        $student->save();
        $studentPhoto = $this->getStudentImageService->execute($student->id);
        $this->assertNull($studentPhoto);
    }
    public function test_cannot_get_student_image_empty_string_photo(): void
    {
        $student = $this->createFakeData();
        $student->photo = "";
        $student->save();
        $studentPhoto = $this->getStudentImageService->execute($student->id);
        $this->assertNull($studentPhoto);
    }

    public function test_cannot_get_student_image_throws_student_not_found_exception(): void
    {
        $this->expectException(StudentNotFoundException::class);
        $this->getStudentImageService->execute("invalid-student-id");
    }

    public function test_handles_unexpected_exceptions(): void
    {
        $this->expectException(\Exception::class);

        $serviceMock = $this->getMockBuilder(GetStudentImageService::class)
            ->onlyMethods(['getStudent'])
            ->getMock();

        $serviceMock->method('getStudent')
            ->will($this->throwException(new \Exception('Unexpected error')));

        $serviceMock->execute('invalid-student-id');
    }

}
