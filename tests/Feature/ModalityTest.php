<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;


class ModalityTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_modality(): void
{
    
    $student = Students::aStudent();
    Resumes::createResumeWithModality($student->id, 'backend', ['some_tag'], ['Presencial', 'Remoto']);

    $response = $this->getJson(route('modality', ['studentId' => $student->id]));

    $response->assertJsonStructure([
        'modality' => []
    ]);

    $response->assertStatus(200);
}
}
