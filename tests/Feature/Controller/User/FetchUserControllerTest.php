<?php

namespace Tests\Feature\Controller\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FetchUserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testFetchAllUsers(): void
    {
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'username',
                        'email',
                        'student',
                        'recruiter',
                    ],
                ],
            ]);

        // Assert count of users based on current database state
        $responseData = $response->json('data');
        $this->assertGreaterThan(0, count($responseData), 'No users found in the database.');
    }

    public function testFetchOnlyStudents(): void
    {
        $response = $this->getJson('/api/v1/users?type=student');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'username',
                        'email',
                        'student',
                        'recruiter',
                    ],
                ],
            ]);

        $responseData = $response->json('data');
        $this->assertTrue(
            collect($responseData)->every(fn ($user) => !is_null($user['student']) && is_null($user['recruiter'])),
            'Some users returned are not students.'
        );
    }

    public function testFetchOnlyRecruiters(): void
    {
        $response = $this->getJson('/api/v1/users?type=recruiter');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'username',
                        'email',
                        'student',
                        'recruiter',
                    ],
                ],
            ]);

        $responseData = $response->json('data');
        $this->assertTrue(
            collect($responseData)->every(fn ($user) => !is_null($user['recruiter']) && is_null($user['student'])),
            'Some users returned are not recruiters.'
        );
    }

    public function testInvalidTypeParameter(): void
    {
        $response = $this->getJson('/api/v1/users?type=invalid');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid type. Allowed values are "student" or "recruiter".',
            ]);
    }

    public function testNoUsersFoundForType(): void
    {
        $response = $this->getJson('/api/v1/users?type=nonexistenttype');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid type. Allowed values are "student" or "recruiter".',
            ]);
    }
}
