<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TermsAndConditionsTest extends TestCase
{
    /**
     * Test return LoremIpsum.
     */

    public function testTermsEndpointReturnsLoremIpsum()
    {
        $response = $this->get('/login/terms-and-conditions');

        $response->assertStatus(200);
        $response->assertJson(['content' => 'Lorem ipsum dolor sit amet...']);
    }

    /**
     * Test is not empty.
     */
    public function testTermsContentIsNotEmpty()
    {
        $response = $this->get('/login/terms-and-conditions');

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('content'));
    }

    /**
     * Test content is string.
     */

    public function testTermsContentIsString()
    {
        $response = $this->get('/login/terms-and-conditions');

        $response->assertStatus(200);
        $this->assertIsString($response->json('content'));
    }

    /**
     * Test has a JSON Header.
     */

    public function testTermsResponseHasJsonHeader()
    {
        $response = $this->get('/login/terms-and-conditions');

        $response->assertHeader('Content-Type', 'application/json');
    }

    /**
     * Test endpoind is valid.
     */

    public function testTermsEndpointIsValid()
    {
        $response = $this->get('/login/terms-and-conditions');

        $response->assertStatus(200);
    }
}
