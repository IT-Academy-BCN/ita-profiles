<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentsListTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetStudentList()
    {
        $response = $this->getJson(route('students.list'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'surname',
                    'photo',
                    'status',
                    'id'
                ],
            ],
        ]);
    }
}