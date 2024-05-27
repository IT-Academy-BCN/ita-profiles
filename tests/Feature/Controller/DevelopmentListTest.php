<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;

class DevelopmentListTest extends TestCase
{
    public function testGetDevelopmentList()
    {
        $response = $this->getJson(route('development.list')); 
        $response->assertStatus(200);

        $developmentList = $response->json();

        $this->assertIsArray($developmentList);
        foreach ($developmentList as $development) {
            $this->assertIsString($development);
        }
    }
}

