<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TermsAndConditionsTest extends TestCase
{
    public function testTermsEndpointIsValid()
    {
        $response = $this->getJson(route('terms-and-conditions'));

        $response->assertStatus(200);
    }

    public function testTermsContentIsNotEmpty()
    {
        $response = $this->getJson(route('terms-and-conditions'));

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('content'));
    }

    public function testTermsContentIsString()
    {
        $response = $this->getJson(route('terms-and-conditions'));

        $response->assertStatus(200);
        $this->assertIsString($response->json('content'));
    }

    public function testTermsEndpointReturnsLoremIpsum()
    {
        $response = $this->getJson(route('terms-and-conditions'));

        $response->assertStatus(200);
        $response->assertJson(['content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi veniam voluptates aperiam laborum est necessitatibus repellendus inventore quis nemo beatae odio, reiciendis quaerat laboriosam harum rerum ab veritatis tempore optio.']);
    }

    public function testTermsResponseHasJsonHeader()
    {
        $response = $this->getJson(route('terms-and-conditions'));

        $response->assertHeader('Content-Type', 'application/json');
    }
}
