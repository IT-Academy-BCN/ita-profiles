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
	
	

    /*

    public function test_user_creation_with_invalid_data(): void
    {
        $response = $this->json('POST', 'api/v1/register', [
            'username' => 667677,
            'dni' => 'Invalid DNI',
            'email' => 'invalid_email',
            'terms' => 'false',
            'password' => 'invalid_password',
            'password_confirmation' => 'invalid_password_confirmation',
        ]);

        $response->assertStatus(422); // 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['username','dni', 'email', 'password']);
    }

    public function test_required_fields_for_user_creation(): void
    {
        $response = $this->json('POST', 'api/v1/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username','dni', 'email', 'password']);
    }*/
}
