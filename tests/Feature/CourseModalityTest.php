<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseModalityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_modality(): void
    {
        $response = $this->getJson(route('modality.course'));

        $response->assertJsonStructure([
            'modality' 
        ]);

        $response->assertStatus(200);
    }
}
