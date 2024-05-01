<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailsService;
use App\Exceptions\StudentNotFoundException;

class StudentDetailsServiceTest extends TestCase
{
    public function test_get_student_details_by_id()
    {
        $service = new StudentDetailsService();

        $student = Resume::factory()->create();

        $result = $service->getStudentDetailsById($student->student_id);

        $this->assertEquals($student->student_id, $result->first()->student_id);
        
    }

    public function test_student_details_not_found()
    {
        $service = new StudentDetailsService();

        $nonExistentStudentId = 'non-existent-student-id';

        $this->expectException(StudentNotFoundException::class);
        $service->getStudentDetailsById($nonExistentStudentId);
    }
}