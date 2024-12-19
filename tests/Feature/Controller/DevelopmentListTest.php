<?php

namespace Tests\Feature\Controller;
use App\Models\Resume;
use Tests\TestCase;

class DevelopmentListTest extends TestCase
{
    public function testGetDevelopmentList()
    {
        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];

        foreach ($developmentOptions as $development) {
            Resume::factory()->create(['development' => $development]);
        }

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $response->assertJsonMissing(['Not Set']);

        foreach (['Spring', 'Laravel', 'Angular', 'React'] as $expectedDevelopment) {
            $response->assertJsonFragment([$expectedDevelopment]);
        }
    }
}

