<?php
//declare(strict_types=1);

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
//use Eloquent\Support\Collection;
//use Mockery;
//use Mockery\MockInterface;

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
		$this->mockery = Mockery::mock('overload:App\Models\User');
	}
	
	/**
     * @dataProvider checkUserCredentialsProvider
     *
     */   
    public function testCheckUserCredentials(string $userDNI, string $password, bool $corerctPasswordBool, bool $addDBBool,bool $expectedOutput)
    {
		
		$randID = rand(1,100);
        
        if($addDBBool == True)
        {	
			/*
			$returnUser = new App\Models\User([
					'id' => intval(rand(1,100)),
					'name' => "Name",
					'surname' => "Surname",
					'email' => $userDNI."@mail.com",
					'dni' => $userDNI,
					'password' => ($corerctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword') ),
				]);
			*/	
			$returnUser = new App\Models\User;
			
			$returnUser->id = intval($randID);
			$returnUser->name = "Name";
			$returnUser->surname = "Surname";
			$returnUser->email = $userDNI."@mail.com";
			$returnUser->dni = $userDNI;
			$returnUser->password = ($corerctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword') );
			
		}else{
			$returnUser = Null;	
		}
		
        $returnCollection = collect([$returnUser]);
        $returnCollection->push($returnUser);
        $returnCollection->add($returnUser);
        
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
        
        
        /*
        $this->mockery->shouldReceive('where')
			->once()
			//->andReturn(True);
			->andReturn($returnCollection);
        */
       
        $this->mockery->shouldReceive('first')
			->once()
			//->andReturn(True);
			->andReturn($returnUser);
        if(empty(User::where('dni', $userDNI)->first()->dni)){
			//Assert Result
			$this->assertEquals(True, True);
		}
		
		$this->mockery->shouldReceive('first')
			->once()
			//->andReturn(True);
			->andReturn($returnUser);
		/*
		$this->mockery->shouldReceive('password')
			->once()
			//->andReturn(True);
			->andReturn($returnUser->password);
		*/
		
		//$this->app->instance(User::class, $this->mockery);
		
		$this->app->instance('overload:App\Models\User', $this->mockery);
		
		
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
			array(
				'48332312C',
				'passOnePass',
				True, //Add In "DB" With True/False Password
				True,  //Add In "DB" (True = Yes , False = No)
				True // Expected Output
				),
			);
		return $array;
    }
    
    /**
     * @dataProvider getUserIDByDNIProvider
     */ 
    public function testGetUserIDByDNI(string $userDNI, bool $addDBBool,bool $expectedOutput)
    {
		
		$randID = rand(1,100);
		if($addDBBool == True)
        {
			$returnUser = new App\Models\User;
			
			$returnUser->id = intval($randID);
			$returnUser->name = "";
			$returnUser->surname = "";
			$returnUser->email = $userDNI."@mail.com";
			$returnUser->dni = $userDNI;
			$returnUser->password = bcrypt("password") ;
			
		}else{
			$returnUser = False;
		}
		
		$returnCollection = collect([$returnUser]);
        //$returnCollection->push($returnUser);
       
        
		$this->mockery->shouldReceive('where')
			->with('dni', $userDNI)
			->andReturn($returnCollection);
			
		$id = $this->service->getUserIDByDNI($userDNI);
		//Assert Result
		if($expectedOutput == False){
			$this->assertEquals(False, $id);
		}else{
			$this->assertEquals($randID, $id);
		}
			
	}
   
     
    static function getUserIDByDNIProvider()
    {
		$array = array(
			array(
				'69818630Z', //NIF/NIE
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
				),
			array(
				'69818630Z', //NIF/NIE
				False, //Add In "DB" (True = Yes , False = No)
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
