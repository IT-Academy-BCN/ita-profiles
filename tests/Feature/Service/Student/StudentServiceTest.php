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
use Illuminate\Support\Facades\DB;

class StudentServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $studentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->studentService = new StudentService();
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }

    /**
     * @dataProvider canSuccessFindingAUserByStudentIdProvider
     */
    public function testCanSuccessFindingAUserByStudentId(string $studentID, string $userID)
    {
        $user = User::factory()->create(['id' => $userID]);
        $student = Student::factory()->create(['id' => $studentID, 'user_id' => $user->id]);

        $foundUser = $this->studentService->findUserByStudentID($student->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    static function canSuccessFindingAUserByStudentIdProvider(): array
    {
        return [
            ['studentID1', 'userID1'],
            ['studentID2', 'userID2'],
        ];
    }

    /**
     * @dataProvider canReturnNotFoundWhenFindingAUserByStudentIdProvider
     */
    public function testCanReturnNotFoundWhenFindingAUserByStudentId(string $studentID)
    {
        $this->expectException(StudentNotFoundException::class);
        $this->studentService->findUserByStudentID($studentID);
    }

    static function canReturnNotFoundWhenFindingAUserByStudentIdProvider(): array
    {
        return [
            ['nonExistingStudentID1'],
            ['nonExistingStudentID2'],
        ];
    }

    /**
     * @dataProvider canReturnUserNotFoundWhenFindingAUserByStudentIdProvider
     */
    public function testCanReturnUserNotFoundWhenFindingAUserByStudentId(string $studentID, string $userID)
    {
        $student = Student::factory()->create(['id' => $studentID, 'user_id' => $userID]);

        $this->expectException(UserNotFoundException::class);
        $this->studentService->findUserByStudentID($student->id);
    }

    static function canReturnUserNotFoundWhenFindingAUserByStudentIdProvider(): array
    {
        return [
            ['studentID1', 'nonExistingUserID1'],
            ['studentID2', 'nonExistingUserID2'],
        ];
    }
    
    protected function tearDown(): void
    {
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        parent::tearDown();
    }

}
