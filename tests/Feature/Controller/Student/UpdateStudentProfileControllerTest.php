<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{
    Resume,
    Student,
    User
};
use App\Service\Student\UpdateStudentProfileService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateStudentProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUser():User
    {
        return User::factory()->create();
    }

    private function createStudent(User $user):Student
    {
        return Student::factory()->for($user)->create();
    }

    private function createResume(Student $student):Resume
    {
        return Resume::factory()->for($student)->create();
    }

    public function test_can_update_student_profile(): void
    {
        $user = $this->createUser();
        $student = $this->createStudent($user);
        $resume = $this->createResume($student);
        $dataToUpdate = array_merge(
            $student->only(['id', 'name', 'surname']),
            $resume->only(['subtitle', 'github_url', 'linkedin_url', 'about']),
            ['tags_ids' => [5, 6, 9]]
        );

        $url = route('student.updateProfile', ['studentId' => $student->id]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(200);
    }

    public function test_can_return_a_404_when_a_student_is_not_found()
    {
        $studentId = "non-exiten-student";
        $dataToUpdate = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'tags_ids' => [1, 2, 3],
        ];

        $url = route('student.updateProfile', ['studentId' => $studentId]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    public function test_can_return_a_404_when_a_resume_is_not_found()
    {
        $user = $this->createUser();
        $student = $this->createStudent($user);

        $dataToUpdate = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'tags_ids' => [1, 2, 3],
        ];

        $url = route('student.updateProfile', ['studentId' => $student->id]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_can_not_update_student_profile_with_invalid_data(array $invalidData, array $expectedErrors): void
    {
        $user = $this->createUser();
        $student = $this->createStudent($user);

        $url = route('student.updateProfile', ['studentId' => $student->id]);
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

    public function test_can_return_a_500_on_internal_server_error(): void
    {
        $this->mock(UpdateStudentProfileService::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->andThrow(new \Exception('Internal Server Error'));
        });

        $user = $this->createUser();
        $student = $this->createStudent($user);
        $resume = $this->createResume($student);

        $dataToUpdate = array_merge(
            $student->only(['id', 'name', 'surname']),
            $resume->only(['subtitle', 'github_url', 'linkedin_url', 'about']),
            ['tags_ids' => [2, 3, 7]]
        );

        $url = route('student.updateProfile', ['studentId' => $student->id]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(500);
    }

}
