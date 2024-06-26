<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Tests\TestCase;
use App\Models\User;

//use App\Service;
use Mockery;
//use Mockery\MockInterface;



/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SigninMockeryTest extends TestCase
{	
	//use DatabaseTransactions;
	
	private $mockery;
	
	public function setUp(): void
	{
		parent::setUp();
		$this->mockery = Mockery::mock('overload:App\Models\User');
	}
	
	public static array $users = array(
		array(
			'dni' => 'NODNI',
			'password' => 'passwordOne',
		),
		array( //Valid NIF and Password But Not Registered User - Pos 1
			'dni' => '57792643Z',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password But Not Registered User - Pos 2
			'dni' => 'X2711281H',
			'password' => 'passOnePass',
		),
		array( //Valid NIF and Wrong Password - Pos 3
			'dni' => '78768396C',
			'password' => '',
		), 
		array( //Valid NIE And Wrong Password - Pos 4
			'dni' => 'Y3449747Z',
			'password' => '',
		),
		array( //Valid NIF and Password YES Registered User - Pos 5
			'dni' => '48332312C',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password YES Registered User - Pos 6
			'dni' => 'Y4527507V',
			'password' => 'passOnePass',
		)
	);
	
	public array $usersRegistered = array(
		array( //Valid NIF and Password YES Registered User - Pos 5
			'dni' => '48332312C',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password YES Registered User - Pos 6
			'dni' => 'Y4527507V',
			'password' => 'passOnePass',
		)
	);
	
	
	private function mockSignIn(string $userDNI, string $password, int $expectedStatusCode, bool $addDBBool = True)
	{
		$randID = rand(1,100);
		if($expectedStatusCode == 200)
        {
			//$returnUser = new App\Models\User;
			$returnUser = new User;
			
			$returnUser->id = intval($randID);
			$returnUser->name = "";
			$returnUser->surname = "";
			$returnUser->email = $userDNI."@mail.com";
			$returnUser->dni = $userDNI;
			$returnUser->password = $password ? bcrypt($password) : bcrypt("password") ;
			
		}else{
			$returnUser = False;
		}
		$returnCollection = null;
		$returnCollection = collect([$returnUser]);
       
        if($expectedStatusCode = 200){
			$this->mockery->shouldReceive('where')
			->twice()
			->with('dni', $userDNI)
			->andReturn($returnCollection);
		}else{
			$this->mockery->shouldReceive('where')
			->once()
			->with('dni', $userDNI)
			->andReturn($returnCollection);
		}
		
		$this->app->instance('overload:App\Models\User', $this->mockery);	
		
		return $randID;
	}
	
	/**
     * @dataProvider signinProvider
     *
     */   
    public function testSigninMockery($data, $expectedStatusCode)
    {
		
		$this->mockSignIn($data['dni'], $data['password'], $expectedStatusCode, True);

		$response = $this->postJson('/api/v1/signin', $data);
		
		$response->assertStatus($expectedStatusCode);
        
    }
    
	
    static function signinProvider()
    {
        $array = array(
			array(
				self::$users[0],
				422
				),
			array(
				self::$users[1],
				401
				),
			array(
				self::$users[2],
				401
				),
			array(
				self::$users[3],
				422
				),
			array(
				self::$users[4],
				422
				),
			array(
				self::$users[5],
				200
				),
			array(
				self::$users[6],
				200
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

