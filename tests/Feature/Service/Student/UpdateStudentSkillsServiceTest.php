<?php
declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\UpdateStudentSkillsService;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\StudentNotFoundException;

class UpdateStudentSkillsServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentSkillsService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->studentSkillsService = new UpdateStudentSkillsService();
    }
	
    
    
    /**
     * @dataProvider canUpdateStudentSkillsByStudentIdProvider
     */ 
    public function testCanUpdateStudentSkillsByStudentId(string $skills): void
    {
		
		$studentID = Resume::first()->student_id;
		$result = $this->studentSkillsService->updateSkillsByStudentId($studentID, $skills);
		$this->assertEquals(True, $result);

    }
    
    
    static function canUpdateStudentSkillsByStudentIdProvider()
    {
		
		$array = array(
			array(
				'["one", "two", "three"]'
				),
			array(
				'[]'
				),
			array(
				'["one"]'
				),
			array(
				'["one", "two", "three"]'
				),
			array(
				'[]',
				),
			);
			
		return $array;
    
	}
    
	/**
     * @dataProvider canThrowStudentNotFoundExceptionWhenTheStudentIsMissingByIdProvider
     */ 
    public function testCanThrowStudentNotFoundExceptionWhenTheStudentIsMissingById(string $studentID, string $skills): void
    {

		$this->expectException(StudentNotFoundException::class);
		 
		$result = $this->studentSkillsService->updateSkillsByStudentId($studentID, $skills);
		
    }
    
    
    static function canThrowStudentNotFoundExceptionWhenTheStudentIsMissingByIdProvider()
    {
		
		$array = array(
			array(
				'1',
				'["one", "two", "three"]'
				),
			array(
				'HOHOHO',
				'[]'
				),
			array(
				'Geil',
				'["one"]'
				),
			);
			
		return $array;
    
	}
	
}
