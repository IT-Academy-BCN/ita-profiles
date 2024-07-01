<?php
declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\{
    Resume,
    Student
};
use Illuminate\Foundation\Testing\{
    DatabaseTransactions
};
use App\Service\Student\UpdateStudentProfileService;
use Tests\TestCase;
use App\Exceptions\{
    StudentNotFoundException,
    ResumeNotFoundException
};

class UpdateStudentProfileServiceTest extends TestCase
{
    use DatabaseTransactions;
    private UpdateStudentProfileService $updateStudentProfileService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->updateStudentProfileService = new UpdateStudentProfileService();
    }

    private function createFakeDataToUpdate(Student $student): array
    {
        $studentData = $student->only(['id', 'name', 'surname']);
        if ($student->resume) {
            $resumeData = $student->resume->only(['subtitle', 'github_url', 'linkedin_url', 'about', 'subtitle']);
            return array_merge($studentData, $resumeData);
        } else {
            return $studentData;
        }
    }

    public function test_can_instantiate_student_update_profile_service()
    {
        $this->assertNotNull($this->updateStudentProfileService);
    }

    public function test_can_update_student_profile()
    {
        $student = Student::factory()->has(Resume::factory())->create();
        $dataToUpdate = $this->createFakeDataToUpdate($student);
        $result = $this->updateStudentProfileService->execute($dataToUpdate['id'], $dataToUpdate);
        $this->assertTrue($result);

        $updatedStudent = Student::find($student->id);
        $this->assertEquals($dataToUpdate['name'], $updatedStudent->name);
        $this->assertEquals($dataToUpdate['surname'], $updatedStudent->surname);

        $updatedResume = $updatedStudent->resume;
        $this->assertEquals($dataToUpdate['github_url'], $updatedResume->github_url);
        $this->assertEquals($dataToUpdate['linkedin_url'], $updatedResume->linkedin_url);
        $this->assertEquals($dataToUpdate['about'], $updatedResume->about);
        $this->assertEquals($dataToUpdate['subtitle'], $updatedResume->subtitle);
    }

    public function test_update_student_profile_throws_student_not_found_exception()
    {
        $this->expectException(StudentNotFoundException::class);

        $dataToUpdate = [
            'id' => 'non-existent-id',
            'name' => 'John',
            'surname' => 'Doe',
            'github_url' => 'https://github.com/johndoe',
            'linkedin_url' => 'https://linkedin.com/in/johndoe',
            'about' => 'Software Developer',
            'subtitle' => 'Analista de Datos'
        ];

        $this->updateStudentProfileService->execute($dataToUpdate['id'], $dataToUpdate);
    }

    public function test_update_student_profile_throws_resume_not_found_exception()
    {
        $this->expectException(ResumeNotFoundException::class);

        $student = Student::factory()->create();
        $dataToUpdate = $this->createFakeDataToUpdate($student);

        try {
            $this->updateStudentProfileService->execute($dataToUpdate['id'], $dataToUpdate);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ResumeNotFoundException::class, $e);
            throw $e;
        }
    }

    /**
     * @dataProvider missingDataProvider
     */
    public function test_can_not_update_student_profile_with_missing_data(array $invalidData)
    {
        $student = Student::factory()->has(Resume::factory())->create();
        $dataToUpdate = $this->createFakeDataToUpdate($student);
        $dataToUpdate = array_merge($dataToUpdate, $invalidData);

        try {
            $result = $this->updateStudentProfileService->execute($dataToUpdate['id'], $dataToUpdate);
        } catch (\Exception $e) {
            $result = false;
        }

        $this->assertFalse($result);
    }

    public static function missingDataProvider(): array
    {
        return [
            'missing_subtitle' => [['subtitle' => null]],
            'missing_github_url' => [['github_url' => null]],
            'missing_linkedin_url' => [['linkedin_url' => null]],
        ];
    }
}
