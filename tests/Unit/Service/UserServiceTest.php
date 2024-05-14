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
use Mockery\MockInterface;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserServiceTest extends TestCase
{	
	private $service;
	public $mockery;
	
	public function setUp(): void
	{
		parent::setUp();
		$this->service = new UserService();
		//$this->mockery =  Mockery::mock('alias:\App\Models\User');
		//$this->app->instance(User::class, $this->mockery);
		$this->mockery = \Mockery::mock('overload:App\Models\User');
	}
	
	/**
     * @dataProvider checkUserCredentialsProvider
     *
     */   
    public function testCheckUserCredentials(string $userDNI, string $password, bool $corerctPasswordBool, bool $addDBBool,bool $expectedOutput)
    {
		
		// Create a mock of the User model
        //$userMock = Mockery::mock(User::class);
        //$userMock =  Mockery::mock('alias:\App\Models\User');
        //$userMock = Mockery::mock('Eloquent', 'alias:\App\Models\User');
        
        if($addDBBool == True)
        {
			$returnUser = new App\Models\User([
					'id' => rand(1,100),
					'name' => "",
					'surname' => "",
					'email' => $userDNI."@mail.com",
					'dni' => $userDNI,
					'password' => "password",//($corerctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword') ),
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
		//$this->app->instance(User::class, $this->mockery);
		///app()->instance(User::class, $userMock);
		//$this->app->instance('alias:\App\Models\User', $userMock);
		
		// Define expectations on the mock
		//$userMock->shouldReceive('where')->once()->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));
		//$userMock->shouldReceive('where')->once()->withAnyArgs()->andReturn(new Collection([$returnUser]));
		//$userMock->shouldReceive('where')->with('dni', $userDNI)->andReturn(new Collection([$returnUser]));
		
		//Eloquent->shouldReceive('where')->once()->withAnyArgs()->andReturn(new Collection([$returnUser]));
		/*
		$user = $this
			->getMockBuilder(User::class)
			->disableOriginalConstructor()
			->setMethods(['__get'])
			->getMock()
		;*/
		/*
		$userMock = $this
			->getMockBuilder(User::class)
			->disableOriginalConstructor()
			->setMethods(['where'])
			->getMock();
		$userMock->expects($this->any())->with('dni', $userDNI)->willReturn(new Collection([$returnUser]));
        */
        // Replace the actual User model with the mock
        //$this->app->instance('App\Models\User', $userMock);
        
        //dd(get_class($userMock));
        
        //$mockFXRate = \Mockery::mock(User::class);
		//$mockFXRate = \Mockery::mock('overload:App\Models\User');
		/*
		$mockFXRate->shouldReceive('where')
			->once()
			->andReturn(new Collection([$returnUser]));
		*/
		/*$mockFXRate->shouldReceive('where')
			->once()
			->andReturn(new Collection([$returnUser]));*/
		/*User::shouldReceive('where')
			->andReturn(new Collection([$returnUser]));
		*/
        // Replace the real User instance with the mocked one
        //$returnCollection = new Collection([$returnUser]);
        $returnCollection = collect([$returnUser]);
        $returnCollection->push($returnUser);
        
        $this->mockery->shouldReceive('where')
			->once()
			//->andReturn(True);
			->andReturn($returnCollection);
		/*
        $this->mockery->shouldReceive('first')
			->once()
			//->andReturn(True);
			->andReturn($returnUser);
			
        $this->app->instance(User::class, $this->mockery);
        */
        //dd(app());
        
        if(empty($returnUser->password)){
			//Assert Result
			$this->assertEquals(True, True);
		}
        if(empty(User::where('dni', $userDNI)->first())){
			//Assert Result
			$this->assertEquals(True, True);
		}
        
        $this->mockery->shouldReceive('where')
			->once()
			//->andReturn(True);
			->andReturn($returnCollection);
        if(empty(User::where('dni', $userDNI)->first()->password)){
			//Assert Result
			$this->assertEquals(True, True);
		}
		
		$this->mockery->shouldReceive('where')
			->once()
			//->andReturn(True);
			->andReturn($returnCollection);
        if(empty(User::where('dni', $userDNI)->first()->dni)){
			//Assert Result
			$this->assertEquals(True, True);
		}
		
        //$result = True;
        
        $this->mockery->shouldReceive('where')
			->once()
			//->andReturn(True);
			->andReturn($returnCollection);
        
        
        
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
    
    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close(); // Clean up Mockery
    }

}

?>
