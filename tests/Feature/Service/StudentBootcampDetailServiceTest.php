<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Service\Student\StudentBootcampDetailService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;

class StudentBootcampDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentWithoutBootcamps;
    protected $studentWithOneBootcamp;
    protected $studentWithTwoBootcamps;
    protected $studentWithoutResume;
    protected $studentBootcampDetailService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentBootcampDetailService = new StudentBootcampDetailService();
        $this->studentWithoutBootcamps = Students::aStudentWithResume();
        $this->studentWithOneBootcamp = Students::aStudentWithOneBootcamp();
        $this->studentWithTwoBootcamps = Students::aStudentWithTwoBootcamps();
        $this->studentWithoutResume = Students::aStudentWithoutResume();
    }

    public function testServiceReturnsBootcampDetailsForStudentWithOneBootcamp(): void
    {
        $service = new StudentBootcampDetailService();

        $bootcampDetails = $service->execute($this->studentWithOneBootcamp->id);

        $this->assertIsArray($bootcampDetails);

        $this->assertCount(1, $bootcampDetails);

        $bootcamp = $this->studentWithOneBootcamp->resume->bootcamps->first();

        foreach ($bootcampDetails as $detail) {
            $this->assertArrayHasKey('bootcamp_id', $detail);
            $this->assertArrayHasKey('bootcamp_name', $detail);
            $this->assertArrayHasKey('bootcamp_end_date', $detail);
            $this->assertEquals($bootcamp->id, $detail['bootcamp_id']);
            $this->assertEquals($bootcamp->name, $detail['bootcamp_name']);
            $this->assertEquals($bootcamp->pivot->end_date, $detail['bootcamp_end_date']);
        }
    }

    public function testServiceReturnsBootcampDetailsForStudentWithTwoBootcamps()
    {
        $student = Students::aStudentWithTwoBootcamps();

        $service = new StudentBootcampDetailService();

        $bootcampDetails = $service->execute($student->id);

        $this->assertIsArray($bootcampDetails);

        $this->assertCount(2, $bootcampDetails);

        $bootcamps = $student->resume->bootcamps->all();

        foreach ($bootcampDetails as $index => $detail) {
            $this->assertArrayHasKey('bootcamp_id', $detail);
            $this->assertArrayHasKey('bootcamp_name', $detail);
            $this->assertArrayHasKey('bootcamp_end_date', $detail);

            $bootcamp = $bootcamps[$index];

            $this->assertEquals($bootcamp->id, $detail['bootcamp_id']);

            $this->assertEquals($bootcamp->name, $detail['bootcamp_name']);

            $this->assertEquals($bootcamp->pivot->end_date, $detail['bootcamp_end_date']);
        }
    }

    public function testServiceHandlesStudentWithoutBootcamps()
    {
        $service = new StudentBootcampDetailService();

        $bootcampDetails = $service->execute($this->studentWithoutBootcamps->id);

        $this->assertIsArray($bootcampDetails);

        $this->assertEmpty($bootcampDetails, "The bootcamp details array should be empty for a student without bootcamps.");
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

    public function testStudentBootcampDetailServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentBootcampDetailService::class, $this->studentBootcampDetailService);
    }
}
