<?php
declare(strict_types=1);

use App\Service;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Depends;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Service\User\UserService;

use Illuminate\Database\Eloquent\Collection;


class UserServiceTest extends TestCase
{	
	private $service;
	
	public function setUp(): void
	{
		parent::setUp();
		$this->service = new UserService();
	}
	
	/**
     * @dataProvider checkUserCredentialsProvider
     *
     */   
    public function testCheckUserCredentials(string $userDNI, string $password, bool $corerctPasswordBool, bool $addDBBool,bool $expectedOutput)
    {
		
		// Create a mock of the User model
        $userMock = Mockery::mock(User::class);
        
        if($addDBBool == True)
        {
			$returnUser = new App\Models\User([
					'id' => rand(1,100),
					'name' => "",
					'surname' => "",
					'email' => $userDNI."@mail.com",
					'dni' => $userDNI,
					'password' => ($corerctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword') ),
				]);
			
			// Define expectations on the mock
			//$userMock->shouldReceive('where')->once()->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));
			
			/*
			// Define the expected behavior for the first() method
			$userMock->shouldReceive('first')
				->once() // Expect the first method to be called once
				->andReturn($returnUser); // Return a specific Product instance
			*/
			
		}else{
			
			$returnUser = Null;
			
			// Define expectations on the mock
			//$userMock->shouldReceive('where')->once()->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));	
			
			/*
			// Define the expected behavior for the first() method
			$userMock->shouldReceive('first')
				->once() // Expect the first method to be called once
				->andReturn($returnUser); // Return a specific Product instance
			*/
		}
		$this->app->instance(User::class, $userMock);
		///app()->instance(User::class, $userMock);
		
		// Define expectations on the mock
		//$userMock->shouldReceive('where')->once()->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));
		$userMock->shouldReceive('where')->once()->withAnyArgs()->andReturn(new Collection([$returnUser]));
		//$userMock->shouldReceive('where')->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));
			
        
        // Replace the actual User model with the mock
        //$this->app->instance('App\Models\User', $userMock);
        
        //dd(get_class($userMock));
        
		//Perform the call to the function to be tested:
		$result = $this->service->checkUserCredentials($userDNI, $password);
		
		//Assert Result
		$this->assertEquals($expectedOutput, $result);
        
    }
    
	
    static function checkUserCredentialsProvider()
    {
        $array = array(
			array(
				'69818630Z', //NIF/NIE
				'password', //Password
				False, //Add In "DB" With True/False Password
				False, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
				),
			array(
				'X6849947H',
				'password',
				False, //Add In "DB" With True/False Password
				False, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
				),
			array(
				'69818630Z',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
				),
			array(
				'X6849947H',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
				),
			array(
				'69818630Z',
				'password',
				False, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
				),
			array(
				'X6849947H',
				'password',
				False, //Add In "DB" With True/False Password
				True,  //Add In "DB" (True = Yes , False = No)
				False // Expected Output
				),
	
			);
		return $array;
    }

}

?>
