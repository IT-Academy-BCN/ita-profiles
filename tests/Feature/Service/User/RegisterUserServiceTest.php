<?php

declare(strict_types=1);

namespace Tests\Feature\Service\User;

use App\Exceptions\UserRegisterException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Service\User\UserRegisterService;

class RegisterUserServiceTest extends TestCase
{
    use DatabaseTransactions; // reverts modifications in DB

    private UserRegisterService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserRegisterService();
    }

    private function createUserData(): array
    {
        return [
            'username' => 'test_username',
            'dni' => '27827083G',
            'email' => 'test_email@test.com',
            'terms' => 'true',
            'password' => 'Password%123',
            'specialization' => 'Backend',
            'password_confirmation' => 'Password%123',
        ];
    }

    public function test_UserRegisterService_can_be_instantiated(): void
    {
        $userRegisterService = new UserRegisterService();
        $this->assertInstanceOf(UserRegisterService::class, $userRegisterService);
    }

    public function test_user_creation_with_valid_data(): void
    {
        $userData = $this->createUserData();

        try {
            $response = $this->userService->createUser($userData);
            $this->assertEquals($userData['email'], $response['email']);
            $this->assertArrayHasKey('token', $response);
            $this->assertIsString($response['token']);
            $this->assertFalse(empty($response['token']) || empty($response['email']));
        } catch (\Exception $e) {
            $this->fail('Exception should not have been thrown: ' . $e->getMessage());
        }
    }

    public function test_user_creation_with_invalid_data(): void
    {
        $registerData = [
            'username' => '',
            'dni' => 'invalidDNI',
            'specialization' => 'invalidSpecialization',
            'terms' => 'false',
            'email' => 'invalidemail',
            'password' => '123456',
        ];

        $this->expectException(UserRegisterException::class);
        $this->userService->createUser($registerData);
    }

    public function test_user_creation_with_empty_data(): void
    {
        $registerData = [
            'username' => '',
            'dni' => '',
            'terms' => '',
            'specialization' => '',
            'email' => '',
            'password' => '',
        ];

        $this->expectException(UserRegisterException::class);
        $this->userService->createUser($registerData);
    }

    /**
     * @dataProvider required_fields_for_user_creation_provider
     *
     * @param array $array Data array with user information to test.
     * @param bool $resultCorrect Expected result of the test (true if user creation should succeed, false otherwise).
     */
    public function test_required_fields_for_user_creation(array $array, bool $resultCorrect): void
    {
        if ($resultCorrect) {
            $response = $this->userService->createUser($array);
            $this->assertNotEmpty($response['email']);
            $this->assertNotEmpty($response['token']);
        } else {
            $this->expectException(\Exception::class);
            $this->userService->createUser($array);
        }
    }

    public static function required_fields_for_user_creation_provider(): array
    {
        return [
            // Missing 'username' field
            [
                [
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'email' => 'test@example.com',
                    'password' => 'password123',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'email' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'password' => 'password123',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'password' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'email' => 'janesmith@example.com',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'dni' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'password123',
                ],
                false,
            ],
            // Missing 'specialization' field
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'password123',
                ],
                false,
            ],
            // Missing 'terms' field
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'specialization' => 'Backend',
                    'password' => 'password123',
                ],
                true,
            ],
        ];
    }
}
