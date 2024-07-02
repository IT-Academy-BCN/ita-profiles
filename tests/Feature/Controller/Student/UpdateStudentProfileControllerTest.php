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
     * Crea datos falsos para actualizar el perfil del estudiante.
     *
     * @return array
     */
    private function createFakeDataToUpdate(): array
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Student $student */
        $student = Student::factory()->for($user)->create();
        /** @var Resume $resume */
        $resume = Resume::factory()->for($student)->create();

        return array_merge(
            $student->only(['id', 'name', 'surname']),
            $resume->only(['subtitle', 'github_url', 'linkedin_url', 'about'])
        );
    }

    public function test_can_update_student_profile(): void
    {
        $dataToUpdate = $this->createFakeDataToUpdate();
        $response = $this->json('PUT', 'api/v1/student/' . $dataToUpdate['id'] . '/resume/profile', $dataToUpdate);

        $response->assertStatus(200);
        $response->assertJson(['profile' => 'El perfil del estudiante se actualizo correctamente']);

        $this->assertDatabaseHas('students', [
            'id' => $dataToUpdate['id'],
            'name' => $dataToUpdate['name'],
            'surname' => $dataToUpdate['surname'],
        ]);

        $this->assertDatabaseHas('resumes', [
            'subtitle' => $dataToUpdate['subtitle'],
            'github_url' => $dataToUpdate['github_url'],
            'linkedin_url' => $dataToUpdate['linkedin_url'],
            'about' => $dataToUpdate['about'],
        ]);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_can_not_update_student_profile_with_invalid_data(array $invalidData, array $expectedErrors): void
    {
        $dataToUpdate = $this->createFakeDataToUpdate();
        $response = $this->json('PUT', 'api/v1/student/' . $dataToUpdate['id'] . '/resume/profile', $invalidData);

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
                ],
                ['name', 'surname', 'subtitle', 'github_url', 'linkedin_url', 'about'],
            ],
        ];
    }

    public function test_required_fields_to_update_student_profile(): void
    {
        $dataToUpdate = $this->createFakeDataToUpdate();
        $response = $this->json('PUT', 'api/v1/student/' . $dataToUpdate['id'] . '/resume/profile', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'surname', 'subtitle']);
    }
}
