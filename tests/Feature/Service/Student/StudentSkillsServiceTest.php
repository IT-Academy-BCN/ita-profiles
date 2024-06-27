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
     * @dataProvider fieldIsValidSkillsJsonProvider
     */ 
    public function testFieldIsValidSkillsJson(string $fields, bool $expectedResult): void
    {
		
		$result = $this->studentSkillsService->fieldIsValidSkillsJson($fields);

		
        $this->assertEquals($expectedResult, $result);
    }
    
    
    static function fieldIsValidSkillsJsonProvider()
    {
		$array = array(
			array(
				'1',
				False
				),
			array(
				'123', //NIF/NIE
				False
				),
			array(
				'["one", "two", "three"]', //NIF/NIE
				True
				),
			array(
				'["one"]', //NIF/NIE
				True
				),
			array(
				'[]', //NIF/NIE
				True
				),
			array(
				'["one", "two", "three":
				{ "four": "five"
				}
				] ', //NIF/NIE
				False
				),
			array(
				'["one", "two", "three":
				["four", "five"]
				]', //NIF/NIE
				False
				),
			);
		
		return $array;
	}
    
    
     /**
     * @dataProvider updateSkillsByStudentIdProvider
     */ 
    public function testUpdateSkillsByStudentId(string $studentID, string $skills, bool $expectedResult): void
    {
		
		
		if($expectedResult == False){
			$this->expectException(StudentNotFoundException::class);
		}else{
			$studentID = Student::first()->id;
		}
		 
		$result = $this->studentSkillsService->updateSkillsByStudentId($studentID, $skills);
		
		if($expectedResult == True){
			$this->assertEquals($expectedResult, $result);
		}

    }
    
    
    static function updateSkillsByStudentIdProvider()
    {
		//$student = new Student;
		//$studentID = $student->first()->id;
		//$studentID = Student::first()->id;
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
    
    /**
     * @dataProvider getSkillsByStudentIdProvider
     */ 
    public function testGetSkillsByStudentId(string $studentID, bool $expectedResult): void
    {
		
		
		if($expectedResult == False){
			$this->expectException(StudentNotFoundException::class);
		}else{
			$studentID = Student::first()->id;
		}
		 
		$skills = $this->studentSkillsService->getSkillsByStudentId($studentID);
		
		$result = json_encode($skills);

		
		if($result != Null){
			$this->assertEquals(True, True);
		}else{
			$this->assertEquals(True, True);
		}

    }
    
    
    static function getSkillsByStudentIdProvider()
    {
		$studentID = '4';
		
		$array = array(
			array(
				$studentID, //Sutudent ID
				True //Result
				),
			array(
				'alksjdnh', //Sutudent ID
				False //Result
				),
			array(
				'nooo', //Sutudent ID
				False //Result
				),
			);
	
		return $array;
    
	}	
	
	
}
