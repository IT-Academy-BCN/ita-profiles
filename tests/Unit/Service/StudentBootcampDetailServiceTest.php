<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Bootcamp;
use App\Service\Student\StudentBootcampDetailService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentBootcampDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentWithoutBootcamps;
    protected $studentWithBootcamps;
    protected $studentWithoutResume;

    public function setUp(): void
    {
        parent::setUp();

        $this->studentWithoutBootcamps = Resume::factory()->create()->student;

        $resume = Resume::factory()->create();
        $bootcamp = Bootcamp::factory()->create();
        $resume->bootcamps()->attach($bootcamp->id, ['end_date' => now()->subYear()->addDays(rand(1, 365))]);

        $this->studentWithBootcamps = $resume->student;

        $this->studentWithoutResume = Student::factory()->create();
    }

    public function testServiceReturnsBootcampDetailsForStudentWithBootcamps()
    {
        $service = new StudentBootcampDetailService();
        $bootcampDetails = $service->execute($this->studentWithBootcamps->id);

        $this->assertIsArray($bootcampDetails);
        $this->assertCount(1, $bootcampDetails['bootcamps']);
    }

    public function testServiceHandlesStudentWithoutBootcamps()
    {
        $service = new StudentBootcampDetailService();
        $bootcampDetails = $service->execute($this->studentWithoutBootcamps->id);

        $this->assertIsArray($bootcampDetails);
        $this->assertEmpty($bootcampDetails['bootcamps']);
    }

    public function testServiceHandlesNonexistentStudent()
    {
        $this->expectException(StudentNotFoundException::class);

        $service = new StudentBootcampDetailService();

        $nonexistentUuid = "00000000-0000-0000-0000-000000000000";
        $service->execute($nonexistentUuid);
    }
    public function testServiceHandlesStudentWithoutResumeAssociated()
    {
        $this->expectException(ResumeNotFoundException::class);

        $service = new StudentBootcampDetailService();

        $service->execute($this->studentWithoutResume->id);
    }
}
