<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

use App\Models\Resume;

class UpdateStudentSkillsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }
	
	/**
     * @dataProvider updateStudentSkillsControllerSuccessProvider
     */
	public function testUpdateStudentSkillsControllerSuccess(array $request): void
    {
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(200);
		$response->assertJson(['status' => 'success']);
  
    }
	
	
	
	static function updateStudentSkillsControllerSuccessProvider()
    {
		$studentID = '4';
		
		$array = array(
			array(

				array(
					'skills' => []
				)
				),
			array(
				array(
					'skills' => ["php","react"]
				)
				),
			array(
				array(
					'skills' => ["html5", "css", "postman"]
				)
				),
			);
	
		return $array;
    
	}


	/**
     * @dataProvider updateStudentSkillsControllerValidationFaliureProvider
     */
	public function testUpdateStudentSkillsControllerValidationFaliure(array $request): void
    {
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(422);
        
    }
	
	
	
	static function updateStudentSkillsControllerValidationFaliureProvider()
    {
		$studentID = '4';
		
		$array = array(
			array(
				array(
					'skills' => "olalala"
				)
				),
			array(
				array(
					'skills' => 1
				)
				)
			);
	
		return $array;
    
	}
	
}
