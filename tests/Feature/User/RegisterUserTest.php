<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\api\RegisterController;
use App\Models\User;
/*
🗒️NOTAS:
1: Genera datos aleatorios de un usuario usando el factory y devuelve los campos en forma de array.

*/

class RegisterUserTest extends TestCase
{
    private function createRandomUserData()
    {
        $userData =  User::factory()->make()->toArray();/*nota 1*/
        $userData['password'] = 'Password%123';
        $userData['password_confirmation'] = 'Password%123';

        return $userData;
    }

    public function test_user_creation_with_valid_data()
    {
        $userData = $this->createRandomUserData();
        $response = $this->json('POST', 'api/v1/register', $userData);        
    
        $response->assertStatus(200);
        $response->assertJson(['message' => 'User registered successfully.']);
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'dni' => $userData['dni'],
        ]);
    }

    public function test_user_creation_with_invalid_data()
    {
        $response = $this->json('POST', 'api/v1/register', [
            'name' => 'Invalid%Name',
            'surname' => 'Invalid%Surname',
            'dni' => 'Invalid DNI',
            'email' => 'invalid_email',
            'password' => 'invalid_password',
            'password_confirmation' => 'invalid_password_confirmation',
        ]);
    
        $response->assertStatus(422); // 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['name', 'surname', 'dni', 'email', 'password']);
    }    

    public function test_required_fields_for_user_creation()
    {
        $response = $this->json('POST', 'api/v1/register', []);
    
        $response->assertStatus(422); 
        $response->assertJsonValidationErrors(['name', 'surname', 'dni', 'email', 'password']);
    }    
}
