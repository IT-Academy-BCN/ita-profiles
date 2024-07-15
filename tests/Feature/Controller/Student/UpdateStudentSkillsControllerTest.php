<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Mockery;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;

use App\Http\Middleware\EnsureStudentOwner;
use App\Models\Resume;
use App\Models\User;

use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;


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
		
		//Mockering middleware
		$ensureStudentMiddleware = Mockery::mock('App\Http\Middleware\EnsureStudentOwner[handle]');
		$ensureStudentMiddleware->shouldReceive('handle')->once()
			->andReturnUsing(function($request, \Closure $next) {
				return $next($request);
			});
		$this->app->instance('App\Http\Middleware\EnsureStudentOwner', $ensureStudentMiddleware);
		
		//Mockering Policy
		$userPolicyMockery= Mockery::mock('App\Policies\UserPolicy');
		$userPolicyMockery->shouldReceive('canAccessResource')->once()
			->andReturn(Response::allow());
		$this->app->instance('App\Policies\UserPolicy', $userPolicyMockery);
		
		
		//Authentuication for Passport
		Passport::actingAs(
			User::factory()->create(),
			['check-status']
		);
		
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(200);
		$response->assertJson(['status' => 'success']);
  
    }
    /*
    public function testUpdateStudentSkillsControllerSuccess(array $request): void
    {
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(200);
		$response->assertJson(['status' => 'success']);
  
    }*/
	
	
	
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
		//Mockering middleware
		$ensureStudentMiddleware = Mockery::mock('App\Http\Middleware\EnsureStudentOwner[handle]');
		$ensureStudentMiddleware->shouldReceive('handle')->once()
			->andReturnUsing(function($request, \Closure $next) {
				return $next($request);
			});
		$this->app->instance('App\Http\Middleware\EnsureStudentOwner', $ensureStudentMiddleware);
		
		//Mockery Passport
		Passport::actingAs(
			User::factory()->create(),
			['check-status']
		);
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(422);
        
    }
    /*
     * public function testUpdateStudentSkillsControllerValidationFaliure(array $request): void
    {
		
		$studentIDReal = Resume::first()->student_id;
		
        $response = $this->json('PUT', 'api/v1/student/'.$studentIDReal.'/resume/skills', $request);
		
		$response->assertStatus(422);
        
    }*/
	
	
	
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
