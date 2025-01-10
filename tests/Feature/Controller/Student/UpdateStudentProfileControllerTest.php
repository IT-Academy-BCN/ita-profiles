<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{Resume, Student, User};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UpdateStudentProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createStudent(User $user): Student
    {
        return Student::factory()->for($user)->create();
    }

    private function createResume(Student $student): Resume
    {
        return Resume::factory()->for($student)->create(['github_url' => 'https://github.com/user1',]);
    }

    public function testCanUpdateStudentProfile(): void
    {
        $user = $this->createUser();
        Passport::actingAs($user);
        $student = $this->createStudent($user);
        $resume = $this->createResume($student);
        $dataToUpdate = array_merge(
            $student->only(['id', 'name', 'surname']),
            $resume->only(['subtitle', 'github_url', 'linkedin_url', 'about']),
            ['tags_ids' => [5, 6, 9]]
        );

        $url = route('student.updateProfile', ['student' => $student]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(200);
    }

    public function testCanReturn404WhenStudentIsNotFound()
    {
        $student = "non-exiten-student";
        $dataToUpdate = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'tags_ids' => [1, 2, 3],
        ];

        $url = route('student.updateProfile', ['student' => $student]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    public function testCanReturn404WhenResumeIsNotFound()
    {
        $user = $this->createUser();
        Passport::actingAs($user);
        $student = $this->createStudent($user);

        $dataToUpdate = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'tags_ids' => [1, 2, 3],
        ];

        $url = route('student.updateProfile', ['student' => $student]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testCanNotUpdateStudentProfileWithInvalidData(array $invalidData, array $expectedErrors): void
    {
        $user = $this->createUser();
        Passport::actingAs($user);
        $student = $this->createStudent($user);

        $url = route('student.updateProfile', ['student' => $student]);
        $response = $this->json('PUT', $url, $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($expectedErrors);
    }

    public static function invalidDataProvider(): array
    {
        return [
            'invalid name and surname' => [
                [
                    'name' => '77878',
                    'surname' => '889655',
                    'subtitle' => 'Valid Subtitle',
                    'github_url' => 'https://valid-url.com',
                    'linkedin_url' => 'https://valid-url.com',
                    'about' => 'Valid about section',
                    'tags_ids' => [1, 2, 3],
                ],
                ['name', 'surname'],
            ],
            'invalid subtitle and urls' => [
                [
                    'name' => 'ValidName',
                    'surname' => 'ValidSurname',
                    'subtitle' => 7878,
                    'github_url' => 'urlInvalida',
                    'linkedin_url' => 'urlInvalida',
                    'about' => 'Valid about section',
                    'tags_ids' => [1, 2, 3],
                ],
                ['subtitle', 'github_url', 'linkedin_url'],
            ],
            'invalid about' => [
                [
                    'name' => 'ValidName',
                    'surname' => 'ValidSurname',
                    'subtitle' => 'Valid Subtitle',
                    'github_url' => 'https://valid-url.com',
                    'linkedin_url' => 'https://valid-url.com',
                    'about' => 9987,
                    'tags_ids' => [1, 2, 3],
                ],
                ['about'],
            ],
            'all fields invalid' => [
                [
                    'name' => '77878',
                    'surname' => '889655',
                    'subtitle' => 7878,
                    'github_url' => 'urlInvalida',
                    'linkedin_url' => 'urlInvalida',
                    'about' => 9987,
                    'tags_ids' => [1, 2, 3],
                ],
                ['name', 'surname', 'subtitle', 'github_url', 'linkedin_url', 'about'],
            ],
        ];
    }
}
