<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterUserControllerTest extends TestCase
{
    use DatabaseTransactions;//ensures that any database modifications made during testing are reverted once the test is complete

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUserData()
    {
        $userData['username'] = 'test_username';
        $userData['dni'] = '27827083G';
        $userData['email'] = 'test_email@test.com';
        $userData['terms'] = 'true';
        $userData['password'] = 'Password%123';
        $userData['specialization'] = 'Backend';
        $userData['password_confirmation'] = 'Password%123';

        return $userData;
    } 

    public function test_user_creation_with_valid_data()
    {
        $userData = $this->createUserData();
        $response = $this->json('POST', 'api/v1/register', $userData);   
     
        $response->assertStatus(200);
        $response->assertJson(['message' => 'User registered successfully.']);
        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'dni' => $userData['dni'],
        ]);
    }

    public function test_user_creation_with_invalid_data()
    {
        $response = $this->json('POST', 'api/v1/register', [
            'username' => 667677,
            'dni' => 'Invalid DNI',
            'email' => 'invalid_email',
            'terms' => 'false',
            'password' => 'invalid_password',
            'password_confirmation' => 'invalid_password_confirmation',
        ]);
    
        $response->assertStatus(422); // 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['username','dni', 'email', 'password']);
    }    

    public function test_required_fields_for_user_creation()
    {
        $response = $this->json('POST', 'api/v1/register', []);
    
        $response->assertStatus(422); 
        $response->assertJsonValidationErrors(['username','dni', 'email', 'password']);
    }    
}
