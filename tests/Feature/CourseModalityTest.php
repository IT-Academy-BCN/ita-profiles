<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CourseModalityTest extends TestCase
{

    use DatabaseTransactions;

    public function test_can_get_modality(): void
    {
        $response = $this->getJson(route('modality.course'));

        $response->assertJsonStructure([
            'modality' 
        ]);

        $response->assertStatus(200);
    }
}
