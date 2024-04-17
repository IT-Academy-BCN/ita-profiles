<?php

namespace Tests\Feature;

use App\Models\Bootcamp;
use App\Models\Resume;
use App\Models\Student;
use Database\Seeders\BootcampSeeder;
use Database\Seeders\ResumeBootcampSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BotcampTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_student_bootcamp_detail_controller_returns_data(): void
    {
        $student = Student::whereHas('resume.bootcamps')->first();
        $response = $this->getJson(route('bootcamp.list', ['id' => $student->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'bootcamps' => [
                '*' => [
                    'bootcamp_id',
                    'bootcamp_name',
                    'bootcamp_end_date',
                ],
            ],
        ]);
    }
}