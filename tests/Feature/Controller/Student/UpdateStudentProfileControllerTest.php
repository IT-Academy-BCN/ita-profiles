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

    private function createFakeDataToUpdate(): array
    {
        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
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

    public function test_can_not_update_student_profile_with_invalid_data(): void
    {
        $dataToUpdate = $this->createFakeDataToUpdate();

        $response = $this->json('PUT', 'api/v1/student/' . $dataToUpdate['id'] . '/resume/profile', [
            'name' => '77878',
            'surname' => '889655',
            'subtitle' => 7878,
            'github_url' => 'urlInvalida',
            'linkedin_url' => 'urlInvalida',
            'about' => 9987,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'surname', 'subtitle', 'github_url', 'linkedin_url', 'about']);
    }

    public function test_required_fields_to_update_student_profile(): void
    {
        $dataToUpdate = $this->createFakeDataToUpdate();

        $response = $this->json('PUT', 'api/v1/student/' . $dataToUpdate['id'] . '/resume/profile', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'surname', 'subtitle']);
    }
}
