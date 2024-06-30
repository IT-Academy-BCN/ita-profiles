<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\StudentSkillsService;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\StudentNotFoundException;

class StudentSkillsServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentSkillsService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->studentSkillsService = new StudentSkillsService();
    }
	
    
    
     /**
     * @dataProvider updateSkillsByStudentIdProvider
     */ 
    public function testUpdateSkillsByStudentId(string $studentID, string $skills, bool $expectedResult): void
    {
		
		
		if($expectedResult == False){
			$this->expectException(StudentNotFoundException::class);
		}else{
			$studentID = Resume::first()->student_id;
		}
		 
		$result = $this->studentSkillsService->updateSkillsByStudentId($studentID, $skills);
		
		if($expectedResult == True){
			$this->assertEquals($expectedResult, $result);
		}

    }
    
    
    static function updateSkillsByStudentIdProvider()
    {

		$studentID = '4';
		
		$array = array(
			array(
				$studentID, //Sutudent ID
				'["one", "two", "three"]', // String
				True //Result
				),
			array(
				$studentID, //Sutudent ID
				'[]', // String
				True //Result
				),
			array(
				$studentID, //Sutudent ID
				'["one"]', // String
				True //Result
				),
			array(
				'No User ID', //Sutudent ID
				'["one", "two", "three"]', // String
				False //Result
				),
			array(
				'0', //Sutudent ID
				'[]', // String
				False //Result
				),
			array(
				'Geil', //Sutudent ID
				'["one"]', // String
				False //Result
				),
			);
			
		return $array;
    
	}
    
	
	
}
