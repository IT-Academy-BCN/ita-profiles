<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

//use App\Models\Student;
use App\Models\Resume;

class StudentSkillsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUserData(): array
    {
        $userData['skills'] = '[]';
        return $userData;
    }
	
	
	/**
     * @dataProvider studentSkillsControllerSuccessProvider
     */
	public function testStudentSkillsControllerSuccess(string $studentID, array $request, bool $expectedResult): void
    {
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		
		if($expectedResult == True){
			$response->assertStatus(200);
			$response->assertJson(['status' => 'success']);
		}else{
			 $response->assertStatus(402);
		
		}
        
    }
	
	
	
	static function studentSkillsControllerSuccessProvider()
    {
		$studentID = '4';
		
		$array = array(
			array(
				$studentID, //Sutudent ID
				array(
					'skills' => []
				),
				True //Result
				),
			array(
				$studentID, //Sutudent ID
				array(
					'skills' => ["php","react"]
				),
				True //Result
				),
			array(
				$studentID, //Sutudent ID
				array(
					'skills' => ["html5", "css", "postman"]
				),
				True //Result
				),
			);
	
		return $array;
    
	}
	
}
