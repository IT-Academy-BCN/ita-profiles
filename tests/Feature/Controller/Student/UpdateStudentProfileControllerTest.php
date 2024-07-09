<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{
    Resume,
    Student,
    User
};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateStudentProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Crea un usuario y un estudiante asociados.
     *
     * @return array
     */
    private function createUserAndStudent(): array
    {
        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        return [$user, $student];
    }

    /**
     * Crea datos falsos para actualizar el perfil del estudiante.
     *
     * @param Student $student
     * @return array
     */
    private function createFakeDataToUpdate(Student $student): array
    {
        $resume = Resume::factory()->for($student)->create();

        return array_merge(
            $student->only(['id', 'name', 'surname']),
            $resume->only(['subtitle', 'github_url', 'linkedin_url', 'about']),
            ['tags_ids' => json_decode($resume->tags_ids)]
        );
    }

    public function test_can_update_student_profile(): void
    {
        [, $student] = $this->createUserAndStudent();
        $dataToUpdate = $this->createFakeDataToUpdate($student);

        $url = route('student.updateProfile', ['studentId' => $dataToUpdate['id']]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(200);
    }

    public function test_can_return_a_404_when_a_student_is_not_found()
    {
        [, $student] = $this->createUserAndStudent();
        $dataToUpdate = $this->createFakeDataToUpdate($student);
        $dataToUpdate['id'] = 'non_existent_studentId';

        $url = route('student.updateProfile', ['studentId' => $dataToUpdate['id']]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    public function test_can_return_a_404_when_a_resume_is_not_found()
    {
        [, $student] = $this->createUserAndStudent();
        $dataToUpdate = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'tags_ids' => [1, 2, 3],
        ];

        $url = route('student.updateProfile', ['studentId' => $student->id]);
        $response = $this->json('PUT', $url, $dataToUpdate);

        $response->assertStatus(404);
    }

    public function test_required_fields_to_update_student_profile(): void
    {
        [, $student] = $this->createUserAndStudent();
        $dataToUpdate = $this->createFakeDataToUpdate($student);
        $url = route('student.updateProfile', ['studentId' => $dataToUpdate['id']]);
        $response = $this->json('PUT', $url, []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tags_ids']);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_can_not_update_student_profile_with_invalid_data(array $invalidData, array $expectedErrors): void
    {
        [, $student] = $this->createUserAndStudent();
        $dataToUpdate = $this->createFakeDataToUpdate($student);
        $url = route('student.updateProfile', ['studentId' => $dataToUpdate['id']]);
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
