<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use App\Models\Student;
use App\Models\Resume;
use App\Models\Bootcamp;
use App\Service\Student\StudentBootcampDetailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentBootcampDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testServiceReturnsBootcampDetailsForStudentWithBootcamps()
    {
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);
        $bootcamps = Bootcamp::factory()->count(2)->create();
        foreach ($bootcamps as $bootcamp) {
            $resume->bootcamps()->attach($bootcamp->id, ['end_date' => now()->subYear()->addDays(rand(1, 365))]);
        }
        $service = new StudentBootcampDetailService();
        $bootcampDetails = $service->execute($student->id);

        $this->assertIsArray($bootcampDetails);
        $this->assertCount(2, $bootcampDetails['bootcamps']);
    }

    public function testServiceHandlesStudentWithoutBootcamps()
    {
        $student = Student::factory()->create();
        Resume::factory()->create(['student_id' => $student->id]);

        $service = new StudentBootcampDetailService();
        $bootcampDetails = $service->execute($student->id);

        $this->assertIsArray($bootcampDetails);
        $this->assertEmpty($bootcampDetails['bootcamps']);
    }

    public function testServiceHandlesNonexistentStudent()
    {
        $this->expectException(ModelNotFoundException::class);

        $service = new StudentBootcampDetailService();
        $service->execute("00000000-0000-0000-0000-000000000000");
    }
}
