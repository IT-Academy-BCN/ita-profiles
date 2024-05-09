<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailService;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentDetailServiceTest extends TestCase
{
    use DatabaseTransactions;
    public function test_get_student_details_by_id()
    {
        $service = new StudentDetailService();

        $resume = Resume::factory()->create();

        $result = $service->getStudentDetailsById($resume->student->id);

        $this->assertEquals($resume->about, $result["about"]);

    }

    public function test_student_details_not_found()
    {
        $service = new StudentDetailService();

        $nonExistentStudentId = 'non-existent-student-id';

        $this->expectException(StudentNotFoundException::class);
        $service->getStudentDetailsById($nonExistentStudentId);
    }
}