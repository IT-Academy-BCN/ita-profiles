<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Service\User\UserService;

class RegisterUserServiceTest extends TestCase
{
    use DatabaseTransactions; //ensures that any database modifications made during testing are reverted once the test is complete

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    private function createUserData()
    {
        $userData['username'] = 'test_username';
        $userData['dni'] = '27827083G';
        $userData['email'] = 'test_email@test.com';
        $userData['password'] = 'Password%123';
        $userData['specialization'] = 'Backend';
        $userData['password_confirmation'] = 'Password%123';

        return $userData;
    }

    public function test_user_creation_with_valid_data()
    {
        $userData = $this->createUserData();

        $request = new RegisterRequest($userData);

        $response = $this->userService->createUser($request);

        $this->assertEquals($userData['email'], $response['email']);
        $this->assertArrayHasKey('token', $response);
        $this->assertIsString($response['token']);
    }

    public function test_user_creation_with_invalid_data()
    {
        $registerData = new RegisterRequest([ // Invalid formats
            'username' => '',
            'dni' => 'invalidDNI',
            'specialization' => 'invalidSpecialization',            
            'email' => 'invalidemail',
            'password' => '123456'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData);
    }

    public function test_user_creation_with_empty_data()
    {
        $registerData = new RegisterRequest([
            'username' => '',
            'dni' => '',
            'specialization' => '',            
            'email' => '',
            'password' => ''
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData);
    }

    public function test_required_fields_for_user_creation()
    {
        // Missing 'username' field
        $registerData1 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'email' => 'test@example.com',
            'password' => 'password123',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData1);

        // Missing 'email' field
        $registerData2 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'password' => 'password123',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData2);

        // Missing 'password' field
        $registerData3 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'email' => 'janesmith@example.com',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData3);

        // Missing 'dni' field
        $registerData4 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'email' => 'alicebrown@example.com',
            'password' => 'password123'
        ]);

        // Missing 'specialization' field
        $registerData4 = new RegisterRequest([
            'username' => 'Alice Brown',
            'dni' => '27827083G',
            'email' => 'alicebrown@example.com',
            'password' => 'password123'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData4);
    }
}
