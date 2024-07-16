<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Service\Student\StudentService;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $studentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->studentService = new StudentService();
    }

    /**
     * @dataProvider findUserByStudentIDSuccessProvider
     */
    public function testFindUserByStudentIDSuccess(string $studentID, string $userID)
    {
        $user = User::factory()->create(['id' => $userID]);
        $student = Student::factory()->create(['id' => $studentID, 'user_id' => $user->id]);

        $foundUser = $this->studentService->findUserByStudentID($student->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    static function findUserByStudentIDSuccessProvider(): array
    {
        return [
            ['studentID1', 'userID1'],
            ['studentID2', 'userID2'],
        ];
    }

    /**
     * @dataProvider findUserByStudentIDNotFoundProvider
     */
    public function testFindUserByStudentIDNotFound(string $studentID)
    {
        $this->expectException(StudentNotFoundException::class);
        $this->studentService->findUserByStudentID($studentID);
    }

    static function findUserByStudentIDNotFoundProvider(): array
    {
        return [
            ['nonExistingStudentID1'],
            ['nonExistingStudentID2'],
        ];
    }

    /**
     * @dataProvider findUserByStudentIDUserNotFoundProvider
     */
    public function testFindUserByStudentIDUserNotFound(string $studentID, string $userID)
    {
        $student = Student::factory()->create(['id' => $studentID, 'user_id' => $userID]);

        $this->expectException(UserNotFoundException::class);
        $this->studentService->findUserByStudentID($student->id);
    }

    static function findUserByStudentIDUserNotFoundProvider(): array
    {
        return [
            ['studentID1', 'nonExistingUserID1'],
            ['studentID2', 'nonExistingUserID2'],
        ];
    }

}
